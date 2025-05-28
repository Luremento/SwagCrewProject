<?php

namespace App\Exports;

use App\Models\Track;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class TracksExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle, ShouldAutoSize, WithEvents
{
    protected $tracks;

    public function __construct($tracks)
    {
        $this->tracks = $tracks;
    }

    public function collection()
    {
        return $this->tracks;
    }

    public function title(): string
    {
        return 'Треки';
    }

    public function headings(): array
    {
        return [
            'ID',
            'Название трека',
            'Исполнитель',
            'Жанр',
            'Длительность',
            'Размер файла (MB)',
            'Формат',
            'Дата загрузки',
            'Количество прослушиваний',
            'В избранном у'
        ];
    }

    public function map($track): array
    {
        return [
            $track->id,
            $track->title,
            $track->user->name,
            $track->genre->name ?? 'Не указан',
            $track->duration ? gmdate('i:s', $track->duration) : 'Не указана',
            $track->file_size ? round($track->file_size / 1024 / 1024, 2) : 'Не указан',
            pathinfo($track->file_path, PATHINFO_EXTENSION),
            $track->created_at->format('d.m.Y H:i'),
            $track->plays_count ?? 0,
            $track->favorites_count ?? 0,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,   // ID
            'B' => 30,  // Название
            'C' => 20,  // Исполнитель
            'D' => 15,  // Жанр
            'E' => 12,  // Длительность
            'F' => 15,  // Размер
            'G' => 10,  // Формат
            'H' => 18,  // Дата
            'I' => 15,  // Прослушивания
            'J' => 15,  // В избранном
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $this->tracks->count() + 1;

        return [
            // Заголовок
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '059669']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ],

            // Все данные
            "A2:J{$lastRow}" => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'CCCCCC']
                    ]
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ]
            ],

            // Центрирование для определенных колонок
            "A2:A{$lastRow}" => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
            ],
            "E2:E{$lastRow}" => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
            ],
            "F2:F{$lastRow}" => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT]
            ],
            "G2:G{$lastRow}" => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
            ],
            "I2:J{$lastRow}" => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $this->tracks->count() + 1;

                // Автофильтр
                $sheet->setAutoFilter("A1:J{$lastRow}");

                // Замораживаем первую строку
                $sheet->freezePane('A2');

                // Итоговая строка
                $totalRow = $lastRow + 2;
                $sheet->setCellValue("A{$totalRow}", 'ИТОГО:');
                $sheet->setCellValue("B{$totalRow}", $this->tracks->count() . ' треков');
                $sheet->setCellValue("F{$totalRow}", round($this->tracks->sum('file_size') / 1024 / 1024, 2) . ' MB');
                $sheet->setCellValue("I{$totalRow}", $this->tracks->sum('plays_count'));
                $sheet->setCellValue("J{$totalRow}", $this->tracks->sum('favorites_count'));

                // Стиль итоговой строки
                $sheet->getStyle("A{$totalRow}:J{$totalRow}")->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F3F4F6']
                    ],
                    'borders' => [
                        'top' => [
                            'borderStyle' => Border::BORDER_THICK,
                            'color' => ['rgb' => '059669']
                        ]
                    ]
                ]);
            }
        ];
    }
}

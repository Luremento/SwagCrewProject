<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class UsersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize, WithEvents
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        return $this->users;
    }

    public function title(): string
    {
        return 'Пользователи';
    }

    public function headings(): array
    {
        return [
            'ID',
            'Имя пользователя',
            'Email адрес',
            'Роль в системе',
            'Статус аккаунта',
            'Количество треков',
            'Темы на форуме',
            'Подписчики',
            'Дата регистрации',
            'Последняя активность'
        ];
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->role === 'admin' ? 'Администратор' : 'Пользователь',
            $user->is_blocked ? 'Заблокирован' : 'Активен',
            $user->tracks_count ?? 0,
            $user->threads_count ?? 0,
            $user->followers_count ?? 0,
            $user->created_at->format('d.m.Y H:i'),
            $user->updated_at->format('d.m.Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $this->users->count() + 1;

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
                    'startColor' => ['rgb' => '4F46E5']
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

            // ID колонка - по центру
            "A2:A{$lastRow}" => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ]
            ],

            // Роль колонка - по центру
            "D2:D{$lastRow}" => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ]
            ],

            // Статус колонка - по центру
            "E2:E{$lastRow}" => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ]
            ],

            // Числовые колонки - по центру
            "F2:H{$lastRow}" => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ]
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $this->users->count() + 1;

                // Настройка ширины колонок вручную для лучшего контроля
                $sheet->getColumnDimension('A')->setWidth(8);   // ID
                $sheet->getColumnDimension('B')->setWidth(25);  // Имя
                $sheet->getColumnDimension('C')->setWidth(35);  // Email
                $sheet->getColumnDimension('D')->setWidth(18);  // Роль
                $sheet->getColumnDimension('E')->setWidth(18);  // Статус
                $sheet->getColumnDimension('F')->setWidth(15);  // Треки
                $sheet->getColumnDimension('G')->setWidth(15);  // Темы
                $sheet->getColumnDimension('H')->setWidth(15);  // Подписчики
                $sheet->getColumnDimension('I')->setWidth(22);  // Регистрация
                $sheet->getColumnDimension('J')->setWidth(22);  // Активность
    
                // Автоподгонка высоты строк
                for ($row = 1; $row <= $lastRow; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(-1);
                }

                // Перенос текста для длинных значений
                $sheet->getStyle("B2:C{$lastRow}")->getAlignment()->setWrapText(true);

                // Добавляем условное форматирование для статусов
                foreach ($this->users as $index => $user) {
                    $row = $index + 2;

                    // Цвет для роли администратора
                    if ($user->role === 'admin') {
                        $sheet->getStyle("D{$row}")->applyFromArray([
                            'font' => [
                                'bold' => true,
                                'color' => ['rgb' => 'DC2626']
                            ]
                        ]);
                    }

                    // Цвет для статуса
                    if ($user->is_blocked) {
                        $sheet->getStyle("E{$row}")->applyFromArray([
                            'font' => [
                                'bold' => true,
                                'color' => ['rgb' => 'DC2626']
                            ],
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'FEE2E2']
                            ]
                        ]);
                    } else {
                        $sheet->getStyle("E{$row}")->applyFromArray([
                            'font' => [
                                'bold' => true,
                                'color' => ['rgb' => '059669']
                            ],
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'ECFDF5']
                            ]
                        ]);
                    }
                }

                // Добавляем автофильтр
                $sheet->setAutoFilter("A1:J{$lastRow}");

                // Замораживаем первую строку
                $sheet->freezePane('A2');

                // Добавляем итоговую строку
                $totalRow = $lastRow + 2;
                $sheet->setCellValue("A{$totalRow}", 'ИТОГО:');
                $sheet->setCellValue("B{$totalRow}", $this->users->count() . ' пользователей');
                $sheet->setCellValue("D{$totalRow}", $this->users->where('role', 'admin')->count() . ' админов');
                $sheet->setCellValue("E{$totalRow}", $this->users->where('is_blocked', false)->count() . ' активных');
                $sheet->setCellValue("F{$totalRow}", $this->users->sum('tracks_count'));
                $sheet->setCellValue("G{$totalRow}", $this->users->sum('threads_count'));
                $sheet->setCellValue("H{$totalRow}", $this->users->sum('followers_count'));

                // Стиль для итоговой строки
                $sheet->getStyle("A{$totalRow}:J{$totalRow}")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 11
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F3F4F6']
                    ],
                    'borders' => [
                        'top' => [
                            'borderStyle' => Border::BORDER_THICK,
                            'color' => ['rgb' => '4F46E5']
                        ]
                    ]
                ]);

                // Добавляем информацию о генерации
                $infoRow = $totalRow + 2;
                $sheet->setCellValue("A{$infoRow}", 'Отчет сгенерирован: ' . now()->format('d.m.Y H:i:s'));
                $sheet->getStyle("A{$infoRow}")->applyFromArray([
                    'font' => [
                        'italic' => true,
                        'size' => 10,
                        'color' => ['rgb' => '6B7280']
                    ]
                ]);
            }
        ];
    }
}

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class RekapPresensiExport implements FromCollection, WithHeadings
{
    protected $rekap;
    protected $bulan;
    protected $tahun;
    protected $nama_bulan;

    public function __construct($rekap, $bulan, $tahun, $nama_bulan)
    {
        $this->rekap = $rekap;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->nama_bulan = $nama_bulan;
    }

    public function collection()
    {
        return new Collection($this->processData());
    }

    private function processData()
    {
        $processedData = [];

        foreach ($this->rekap as $d) {
            $row = [
                'NUPTK' => $d->nuptk,
                'Nama Guru' => $d->nama_lengkap,
            ];

            $totalhadir = 0;
            $totalterlambat = 0;

            for ($i = 1; $i <= 31; $i++) {
                $tgl = "tanggal_" . $i;
                if (empty($d->$tgl)) {
                    $row["Tanggal $i"] = '';
                } else {
                    $hadir = explode("-", $d->$tgl);
                    $row["Tanggal $i"] = $hadir[0] . ' - ' . $hadir[1];
                    $totalhadir += 1;

                    if ($hadir[0] > "07:30:00") {
                        $totalterlambat += 1;
                    }
                }
            }

            $row['Total Hadir'] = $totalhadir;
            $row['Total Terlambat'] = $totalterlambat;

            $processedData[] = $row;
        }

        return $processedData;
    }

    public function headings(): array
    {
        return [
            'NUPTK',
            'Nama Guru',
            'Tanggal 1',
            'Tanggal 2',
            'Tanggal 3',
            'Tanggal 4',
            'Tanggal 5',
            'Tanggal 6',
            'Tanggal 7',
            'Tanggal 8',
            'Tanggal 9',
            'Tanggal 10',
            'Tanggal 11',
            'Tanggal 12',
            'Tanggal 13',
            'Tanggal 14',
            'Tanggal 15',
            'Tanggal 16',
            'Tanggal 17',
            'Tanggal 18',
            'Tanggal 19',
            'Tanggal 20',
            'Tanggal 21',
            'Tanggal 22',
            'Tanggal 23',
            'Tanggal 24',
            'Tanggal 25',
            'Tanggal 26',
            'Tanggal 27',
            'Tanggal 28',
            'Tanggal 29',
            'Tanggal 30',
            'Tanggal 31',
            'Total Hadir',
            'Total Terlambat',
        ];
    }
}

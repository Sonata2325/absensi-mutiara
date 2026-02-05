<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Absensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-bold">Laporan Absensi</h1>
        <button onclick="window.print()" class="px-3 py-2 rounded-lg border text-sm">Print / Save as PDF</button>
    </div>
    <div class="text-sm text-gray-700 mb-4">Periode: {{ $start }} s/d {{ $end }}</div>

    <div class="border rounded-xl overflow-hidden">
        <table class="min-w-full text-xs">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="p-2">Tanggal</th>
                    <th class="p-2">Nama</th>
                    <th class="p-2">Posisi</th>
                    <th class="p-2">Shift</th>
                    <th class="p-2">Masuk</th>
                    <th class="p-2">Keluar</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Overtime</th>
                    <th class="p-2">Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendances as $a)
                    <tr class="border-t">
                        <td class="p-2">{{ $a->tanggal?->toDateString() }}</td>
                        <td class="p-2">{{ $a->employee?->name }}</td>
                        <td class="p-2">{{ $a->employee?->position?->nama_posisi }}</td>
                        <td class="p-2">{{ $a->employee?->shift?->nama_shift }}</td>
                        <td class="p-2">{{ $a->jam_masuk }}</td>
                        <td class="p-2">{{ $a->jam_keluar }}</td>
                        <td class="p-2">{{ $a->status }}</td>
                        <td class="p-2">{{ $a->status === 'overtime' ? 'Ya' : '-' }}</td>
                        <td class="p-2">{{ $a->keterangan ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>

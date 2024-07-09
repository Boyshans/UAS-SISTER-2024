<x-admin-layout>

<div class="ml-16 p-4 max-w-7xl px-4 py-5 sm:px-6 lg:px-8 bg-white">
<div class="mt-6">
<!-- Table Structure -->
<table class="table-auto w-full">
    <thead>
        <tr class="bg-gray-100">
            <th class="px-4 py-2 border">No</th>
            <th class="px-4 py-2 border">Nama</th>
            <th class="px-4 py-2 border">NIM</th>
            <th class="px-4 py-2 border">Tanggal Lahir</th>
            <th class="px-4 py-2 border">Semester</th>
            <th class="px-4 py-2 border">Jurusan</th>
            <th class="px-4 py-2 border">Foto</th>
            <th class="px-4 py-2 border">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <!-- Loop through mahasiswas -->
        @foreach ($mahasiswas as $index => $mahasiswa)
        <tr>
            <td class="px-4 py-2 border">{{ $index + 1 }}</td>
            <td class="px-4 py-2 border">{{ $mahasiswa->nama }}</td>
            <td class="px-4 py-2 border">{{ $mahasiswa->nim }}</td>
            <td class="px-4 py-2 border">{{ $mahasiswa->tanggal_lahir }}</td>
            <td class="px-4 py-2 border">{{ $mahasiswa->semester }}</td>
            <td class="px-4 py-2 border">{{ $mahasiswa->jurusan }}</td>
            <td class="px-4 py-2 border">
                @if ($mahasiswa->foto)
                    <img src="{{ asset('storage/' . $mahasiswa->foto) }}" alt="Foto Mahasiswa" class="h-12 w-12 object-cover">
                @else
                    Tidak ada foto
                @endif
            </td>
            <td class="px-4 py-2 border">
                <a href="{{ route('mahasiswas.edit', ['mahasiswa' => $mahasiswa->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                <form action="{{ route('mahasiswas.destroy', ['mahasiswa' => $mahasiswa->id]) }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

        </div>
    </div>
</x-admin-layout>

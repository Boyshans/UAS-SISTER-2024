<x-admin-layout>
    <div class="ml-2 p-2 max-w- px-4  sm:px-6 lg:px-8 bg-white">
        <h1 class=" text-lg antialiased font-bold pt-5">Data Mahasiswa</h1>
        <div class="mt-6">
            <!-- Table Structure -->
            <table class="table-auto w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border ">No</th>
                        <th class="px-4 py-2 border">Foto</th>
                        <th class="px-4 py-2 border">Nama</th>
                        <th class="px-4 py-2 border">NIM</th>
                        <th class="px-4 py-2 border">Tanggal Lahir</th>
                        <th class="px-4 py-2 border">Semester</th>
                        <th class="px-4 py-2 border">Jurusan</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through mahasiswas -->
                    @foreach ($mahasiswas as $index => $mahasiswa)
                        <tr>
                            <td class="px-4 py-2 border text-center">{{ $loop->iteration + ($mahasiswas->currentPage() - 1) * $mahasiswas->perPage() }}</td>
                            <td class="px-4 py-2 border">
                                @if ($mahasiswa->foto)
                                    <img src="{{ asset('storage/' . $mahasiswa->foto) }}" alt="Foto Mahasiswa" class="h-12 w-12 flex align-item-center ml-1">
                                @else
                                <img src="{{ asset('storage/fotos/OIP (2).jpeg') }}" alt="Foto Default" class="h-12 w-12 flex align-item-center ml-1">
                                @endif
                            </td>
                            <td class="px-4 py-2 border text-center">{{ $mahasiswa->nama }}</td>
                            <td class="px-4 py-2 border text-center">{{ $mahasiswa->nim }}</td>
                            <td class="px-4 py-2 border text-center">{{ $mahasiswa->tanggal_lahir }}</td>
                            <td class="px-4 py-2 border text-center">{{ $mahasiswa->semester }}</td>
                            <td class="px-4 py-2 border text-center">{{ $mahasiswa->jurusan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Tambahkan link navigasi pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $mahasiswas->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>

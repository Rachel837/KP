<div class="container mt-4">

    <h2 style="font-weight: 500;">Jadwal</h2>
    <hr>

    @foreach ($jadwal as $tanggal => $items)
        <div class="mb-5">

            {{-- Tanggal --}}
            <p style="font-size: 14px;">{{ $tanggal }}</p>

            {{-- Header --}}
            <div style="display: flex; border-bottom: 1px solid #999; padding-bottom: 8px;">
                <div style="width: 20%;">jam</div>
                <div style="width: 50%; border-left:1px solid #999; border-right:1px solid #999; text-align:center;">
                    Nama alm
                </div>
                <div style="width: 30%; text-align:right;">Mesin</div>
            </div>

            {{-- Isi --}}
            @foreach ($items as $item)
                <div style="display: flex; padding: 15px 0;">
                    
                    {{-- Jam --}}
                    <div style="width: 20%;">
                        {{ $item->jam_awal }} - {{ $item->jam_akhir }}
                    </div>

                    {{-- Nama --}}
                    <div style="width: 50%; border-left:1px solid #999; border-right:1px solid #999; text-align:center;">
                        {{ $item->pelanggan->nama ?? '-' }}
                    </div>

                    {{-- Mesin --}}
                    <div style="width: 30%; text-align:right;">
                        {{ $item->ruangan->nama ?? '-' }}
                    </div>
                </div>
            @endforeach

        </div>
    @endforeach

</div>
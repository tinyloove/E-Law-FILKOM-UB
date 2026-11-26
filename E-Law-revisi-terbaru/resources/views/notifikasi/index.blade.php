@extends('layouts.portal')

@section('title', 'Notifikasi')

@section('content')
    <div class="tim-tugas">
        <div class="tim-tugas-heading">
            <p class="tim-tugas-eyebrow">E-Law</p>
            <h1>Notifikasi</h1>
            <p>Lihat informasi terbaru terkait pengaduanmu.</p>
        </div>

        <section class="tim-tugas-card">
            @forelse ($notifikasis as $notifikasi)
                <article style="padding: 16px 0; border-bottom: 1px solid #e9e3e7;">
                    <p>{{ $notifikasi->isi_notifikasi }}</p>

                    <small>
                        {{ \Carbon\Carbon::parse($notifikasi->waktu_dibuat)->format('d-m-Y H:i') }}
                        · {{ $notifikasi->status_notifikasi }}
                    </small>

                    @if ($notifikasi->status_notifikasi === 'Belum Dibaca')
                        <form action="{{ route('notifikasi.dibaca', $notifikasi->id_notifikasi) }}"
                              method="POST">
                            @csrf

                            <button type="submit" style="margin-top: 12px;">
                                Tandai sudah dibaca
                            </button>
                        </form>
                    @endif
                </article>
            @empty
                <div class="tim-tugas-empty">
                    <h3>Belum ada notifikasi</h3>
                    <p>Informasi baru akan muncul di halaman ini.</p>
                </div>
            @endforelse
        </section>
    </div>
@endsection
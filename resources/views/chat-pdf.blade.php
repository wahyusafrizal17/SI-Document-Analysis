@extends('layouts.app-2') 
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content ">
  <div class="content-overlay"></div>
  {{-- <div class="header-navbar-shadow"></div> --}}
  <div class="content-wrapper container-xxl p-0">
    <div class="content-header row"></div>
    <div class="content-body">
      <section id="dashboard-ecommerce">
        <div class="row match-height">
          <div class="col-md-12">
            <div class="content-chat d-flex flex-column" id="content-chat">
              <div style="padding: 30px;">
                <div id="welcome-box" class="box-sambutan" style="display: block;">
  <div style="position:absolute; right: 390px; background-color:#FFD700; width: 213px; height: 62px; transform:rotate(1.73deg); border-radius:10px; z-index: 1; margin-top: 15px;" class="landing-header-pdf-highlight" aria-hidden="true"></div>
  <h1 class="text-sambutan">Selamat Datang!</h1>
  <p class="p-sambutan mt-2">
    Selamat datang di TEDC ChatDoc AI! Temukan informasi yang Anda butuhkan tentang kampus, program studi, jadwal akademik, dan layanan lainnya. <br><br>
    Apa yang ingin Anda cari hari ini?
  </p>
</div>

<div class="show-chat" id="chat-box" style="display: none;"></div>


                {{-- <div class="show-chat" @if(empty($list_chat)) style="display: none" @endif>
                    @foreach($list_chat as $row)
                    <div class="sent">
                        <span class="chat-sent">{{ $row->sent }}
                            <div class="chat-date">{{ $row->created_at }}</div>
                        </span>
                    </div>
                    <div class="accepted">
                        <span class="chat-accepted">
                            <p>{!! nl2br(e($row->accepted)) !!}</p>
                        </span>
                    </div>
                    @endforeach
                </div> --}}
                
                    {{-- <div class="show-chat" style="display: none">
                        <div class="sent">
                            <span class="chat-sent">simpulan dari dokumen ini
                                <div class="chat-date">2025-02-26 10:20:09</div>
                            </span>
                        </div>
                        <div class="accepted">
                            <span class="chat-accepted">
                                <p>Dokumen ini menyajikan Laporan Kinerja Inspektorat Bidang Kinerja Kelembagaan Tahun Anggaran 2023, yang mencakup komitmen terhadap peningkatan integritas, akuntabilitas, transparansi, dan kinerja aparatur. Laporan ini menjelaskan penurunan indikator kinerja, rencana kerja, serta hasil reviu atas berbagai kegiatan dan anggaran. Selain itu, terdapat rekomendasi untuk perbaikan dan integrasi manajemen risiko dalam proses perencanaan. Secara keseluruhan, dokumen ini bertujuan untuk menjadi tolok ukur kinerja dan dasar evaluasi bagi instansi terkait, serta mendukung pelaksanaan Sistem Akuntabilitas Kinerja Intern Pemerintah (SAKIP).
                                    <br>Dokumen Laporan Kinerja (LKj) Inspektorat Bidang Administrasi Umum (IBAU) tahun 2023 menyimpulkan bahwa laporan ini merupakan bentuk akuntabilitas atas pelaksanaan tugas dan fungsi IBAU. Laporan ini bertujuan untuk mengukur keberhasilan program pengawasan dan peningkatan akuntabilitas keuangan serta kinerja, sesuai dengan indikator kinerja utama yang telah ditetapkan. Diharapkan, LKj ini dapat menjadi sumber informasi yang berguna untuk evaluasi dan perbaikan kinerja di masa mendatang, sehingga sasaran kinerja dapat tercapai sesuai target yang telah ditetapkan.
                                    <br>Dokumen ini adalah Laporan Kinerja Inspektorat Utama Tahun 2023 yang mencakup evaluasi atas kapabilitas Aparat Pengawasan Intern Pemerintah (APIP) berdasarkan enam elemen penilaian. Laporan ini menunjukkan bahwa Inspektorat Utama telah mencapai target kinerja 100% dalam pelaksanaan rencana aksi reformasi birokrasi. Selain itu, laporan ini juga mencakup kontribusi Inspektorat Utama terhadap pencapaian Kementerian PPN/Bappenas dan evaluasi internal atas berbagai kegiatan utama. Rekomendasi dari hasil audit menunjukkan bahwa transformasi Kementerian PPN/Bappenas perlu ditingkatkan untuk meningkatkan kualitas perencanaan dan pengendalian pembangunan nasional.
                                    <br>
                                </p>
                            </span>
                        </div>
                    </div> --}}
              </div>
            </div>
            <form onsubmit="sendMessage(); return false;" class="mt-auto" style="padding: 0px 30px 0px 30px;background: #3a3a3a">
              <div class="input-group input-group-merge" style="height: 60px;">
                <input type="text" class="form-control value-message" id="basic-default-password1" placeholder="Bagaimana kami bisa membantu Anda hari ini?" aria-describedby="basic-default-password1" autocomplete="off" style="background: #575757;border-radius: 30px 0px 0px 30px;color: white;">
                <span class="input-group-text cursor-pointer" onclick="sendMessage()" style="background: #575757;border-radius: 0px 30px 30px 0px;">
                  <div style="background: hsl(240 5.9% 10%);color: white;border-radius: 50%;">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 30px;height: 30px;">
                      <path d="M9.5 4C8.67157 4 8 4.67157 8 5.5V18.5C8 19.3284 8.67157 20 9.5 20C10.3284 20 11 19.3284 11 18.5V5.5C11 4.67157 10.3284 4 9.5 4Z" fill="currentColor"></path>
                      <path d="M13 8.5C13 7.67157 13.6716 7 14.5 7C15.3284 7 16 7.67157 16 8.5V15.5C16 16.3284 15.3284 17 14.5 17C13.6716 17 13 16.3284 13 15.5V8.5Z" fill="currentColor"></path>
                      <path d="M4.5 9C3.67157 9 3 9.67157 3 10.5V13.5C3 14.3284 3.67157 15 4.5 15C5.32843 15 6 14.3284 6 13.5V10.5C6 9.67157 5.32843 9 4.5 9Z" fill="currentColor"></path>
                      <path d="M19.5 9C18.6716 9 18 9.67157 18 10.5V13.5C18 14.3284 18.6716 15 19.5 15C20.3284 15 21 14.3284 21 13.5V10.5C21 9.67157 20.3284 9 19.5 9Z" fill="currentColor"></path>
                    </svg>
                  </div>
                </span>
              </div>
            </form>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>
<!-- END: Content-->
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        @guest
            $('#loginModal').modal("show");
        @endguest
    });

    function showRegister() {
        $('#loginModal').modal("hide");
        $('#registerModal').modal("show");
    }

    function showLogin() {
        $('#registerModal').modal("hide");
        $('#loginModal').modal("show");
    }

    function formatPreserved(content) {
        return content
        ? content.replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/\n/g, "<br>")
        : '';
    }

    function scrollToBottom() {
        var contentChat = document.querySelector('.content-chat');
        if (contentChat) {
            contentChat.scrollTo({
                top: contentChat.scrollHeight,
                behavior: 'smooth' // Enable smooth scrolling
            });
        }
    }

    function sendMessage() {
    const message = $('.value-message').val();
    if (!message.trim()) return;

    const now = new Date();
    const formattedDate = now.getFullYear() + "-" +
        String(now.getMonth() + 1).padStart(2, '0') + "-" +
        String(now.getDate()).padStart(2, '0') + " " +
        String(now.getHours()).padStart(2, '0') + ":" +
        String(now.getMinutes()).padStart(2, '0') + ":" +
        String(now.getSeconds()).padStart(2, '0');

    $('.box-sambutan').hide();
    $('.show-chat').show();

    // Buat elemen HTML sementara (kita perlu referensinya nanti)
    const sentHtml = `
        <div class="sent">
            <span class="chat-sent">${message}
                <div class="chat-date">${formattedDate}</div>
            </span>
        </div>
    `;

    const acceptedHtml = $(`
        <div class="accepted">
            <span class="chat-accepted">
                <p><em>Processing...</em></p>
            </span>
        </div>
    `);

    // Tambahkan ke DOM
    $('.show-chat').append(sentHtml);
    $('.show-chat').append(acceptedHtml);

    // Kosongkan input
    $('.value-message').val('');
    scrollToBottom();

    $.ajax({
        url: '/send-message',
        method: 'POST',
        data: {
            message: message,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            acceptedHtml.find('.chat-accepted').html(`<p>${formatPreserved(response.combined_content)}</p>`);
            scrollToBottom();
        },
        error: function(xhr, status, error) {
            acceptedHtml.find('.chat-accepted').html(`<p style="color:red;">Terjadi kesalahan: ${error}</p>`);
            console.error('Error sending message:', error);
        }
    });
}




</script>
@endpush

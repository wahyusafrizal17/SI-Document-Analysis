@extends('layouts.app-2') 
@section('content') 

    <!-- BEGIN: Content-->
    <div class="app-content content py-3 mb-0">
        <div class="content-overlay"></div>
        <div class="content-wrapper container-xxl p-0 mt-3">
            <div class="content-header row">
            </div>
            <div class="content-body">
                
                <section id="dashboard-ecommerce">
                    <div class="row match-height">
                        <div class="col-md-3">
                            <div class="card card-histori mb-0">
                                <div class="card-header">
                                    <h3 class="mb-75">Histori:</h4>
                                </div>
                                <div class="card-body">
                                    <div class="">
                                        @if($histori->isEmpty())
                                            <p class="text-center"><i>Belum ada pencarian</i></p>
                                        @else
                                            @foreach($histori as $row)
                                            <p class="card-text card-text-active">Febuari 15, 2025</p>
                                            <hr>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="content-chat d-flex flex-column" id="content-chat">
                                <div style="padding: 30px;">
                                    {{-- <div class="box-sambutan">
                                        <div style="position:absolute;right: 317px;background-color:#FFD700;width: 213px;height: 62px;transform:rotate(1.73deg);border-radius:10px;z-index: 1;margin-top: 12px;" class="landing-header-pdf-highlight" aria-hidden="true"></div>
                                        <h1 class="text-sambutan">
                                            Selamat Datang!
                                        </h1>
                                        <p class="p-sambutan mt-2">Selamat datang di TEDC ChatDoc AI! Temukan informasi yang Anda butuhkan tentang kampus, program studi, jadwal akademik, dan layanan lainnya.<br><br>Apa yang ingin Anda cari hari ini?</p>
                                    </div> --}}
                                    <div class="sent">
                                        <span class="chat-sent">simpulan dari dokumen ini
                                            <div class="chat-date">2025-02-26 10:20:09</div>
                                        </span>
                                    </div>
                                    <div class="accepted"><span class="chat-accepted">
                                        <p>Dokumen ini menyajikan Laporan Kinerja Inspektorat Bidang Kinerja Kelembagaan Tahun Anggaran 2023, yang mencakup komitmen terhadap peningkatan integritas, akuntabilitas, transparansi, dan kinerja aparatur. Laporan ini menjelaskan penurunan indikator kinerja, rencana kerja, serta hasil reviu atas berbagai kegiatan dan anggaran. Selain itu, terdapat rekomendasi untuk perbaikan dan integrasi manajemen risiko dalam proses perencanaan. Secara keseluruhan, dokumen ini bertujuan untuk menjadi tolok ukur kinerja dan dasar evaluasi bagi instansi terkait, serta mendukung pelaksanaan Sistem Akuntabilitas Kinerja Intern Pemerintah (SAKIP).<br>Dokumen Laporan Kinerja (LKj) Inspektorat Bidang Administrasi Umum (IBAU) tahun 2023 menyimpulkan bahwa laporan ini merupakan bentuk akuntabilitas atas pelaksanaan tugas dan fungsi IBAU. Laporan ini bertujuan untuk mengukur keberhasilan program pengawasan dan peningkatan akuntabilitas keuangan serta kinerja, sesuai dengan indikator kinerja utama yang telah ditetapkan. Diharapkan, LKj ini dapat menjadi sumber informasi yang berguna untuk evaluasi dan perbaikan kinerja di masa mendatang, sehingga sasaran kinerja dapat tercapai sesuai target yang telah ditetapkan.<br>Dokumen ini adalah Laporan Kinerja Inspektorat Utama Tahun 2023 yang mencakup evaluasi atas kapabilitas Aparat Pengawasan Intern Pemerintah (APIP) berdasarkan enam elemen penilaian. Laporan ini menunjukkan bahwa Inspektorat Utama telah mencapai target kinerja 100% dalam pelaksanaan rencana aksi reformasi birokrasi. Selain itu, laporan ini juga mencakup kontribusi Inspektorat Utama terhadap pencapaian Kementerian PPN/Bappenas dan evaluasi internal atas berbagai kegiatan utama. Rekomendasi dari hasil audit menunjukkan bahwa transformasi Kementerian PPN/Bappenas perlu ditingkatkan untuk meningkatkan kualitas perencanaan dan pengendalian pembangunan nasional.<br></p></span>
                                    </div>
                            
                                </div>
                                
                            </div>
                            <form onsubmit="sendMessage(); return false;" class="mt-auto" style="padding: 10px 0px 0px 0px;background: rgb(248, 248, 248);">
                                <div class="input-group input-group-merge form-password-toggle" style="height: 60px;">
                                    <input type="text" class="form-control value-message" id="basic-default-password1" placeholder="Ask anythink" aria-describedby="basic-default-password1">
                                    <span class="input-group-text cursor-pointer" onclick="sendMessage()">
                                        <div style="background: hsl(240 5.9% 10%);color: white;border-radius: 50%;">
                                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"  style="width: 30px;height: 30px;"><path d="M9.5 4C8.67157 4 8 4.67157 8 5.5V18.5C8 19.3284 8.67157 20 9.5 20C10.3284 20 11 19.3284 11 18.5V5.5C11 4.67157 10.3284 4 9.5 4Z" fill="currentColor"></path><path d="M13 8.5C13 7.67157 13.6716 7 14.5 7C15.3284 7 16 7.67157 16 8.5V15.5C16 16.3284 15.3284 17 14.5 17C13.6716 17 13 16.3284 13 15.5V8.5Z" fill="currentColor"></path><path d="M4.5 9C3.67157 9 3 9.67157 3 10.5V13.5C3 14.3284 3.67157 15 4.5 15C5.32843 15 6 14.3284 6 13.5V10.5C6 9.67157 5.32843 9 4.5 9Z" fill="currentColor"></path><path d="M19.5 9C18.6716 9 18 9.67157 18 10.5V13.5C18 14.3284 18.6716 15 19.5 15C20.3284 15 21 14.3284 21 13.5V10.5C21 9.67157 20.3284 9 19.5 9Z" fill="currentColor"></path></svg>
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
    
    @endsection
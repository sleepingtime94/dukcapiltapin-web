<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4">
                    <h4 class="text-primary border-bottom pb-2 mb-4">
                        <i class="bi bi-journal-text me-2"></i> <?= $subtitle ?>
                    </h4>
                    <div class="list-group list-group-flush">
                        <div class="mb-4">
                            <div class="list-group document-list overflow-auto h-400px">
                                <?php foreach ($data as $item): ?>
                                    <a href="https://files.dukcapil.tapinkab.go.id/<?= $item['path'] ?>" class="list-group-item list-group-item-action d-flex align-items-center" target="_blank">
                                        <i class="bi bi-file-pdf text-danger fs-4 me-3"></i>
                                        <span><?= $item['title'] ?></span>
                                        <i class="bi bi-box-arrow-up-right ms-auto"></i>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="content-section bg-white rounded-4 p-4 mb-4">
                <h5 class="fw-bold mb-4 border-start border-4 border-primary ps-3">Menu Layanan</h5>
                <div class="card h-100 border-0 shadow-sm rounded-4 service-card mb-3">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="service-icon rounded-circle bg-success bg-opacity-10 p-3 me-3">
                                <img src="/assets/img/ONLINE.png" alt="Pondok Dukcapil Icon" width="64" height="64">
                            </div>
                            <h5 class="card-title fw-bold mb-0">Pondok Dukcapil</h5>
                        </div>
                        <p class="card-text">Pelayanan online adminduk, penerbitan Kartu Keluarga, Akta Kelahiran, Pindah Datang dan lainnya.</p>
                        <a href="https://pondok.dukcapil.tapinkab.go.id" class="btn btn-success rounded-pill px-4" target="_blank">
                            <i class="bi bi-box-arrow-up-right me-2"></i>Registrasi
                        </a>
                    </div>
                </div>
                <div class="card h-100 border-0 shadow-sm rounded-4 service-card">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="service-icon rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                                <img src="/assets/img/IKD.png" alt="IKD Icon" width="64" height="64">
                            </div>
                            <h5 class="card-title fw-bold mb-0">Identitas Kependudukan Digital</h5>
                        </div>
                        <p class="card-text">Data kependudukan digital seperti KTP, Kartu Keluarga dan dokumen kependudukan lainnya.</p>
                        <a href="/publikasi/identitas-kependudukan-digital" class="btn btn-danger rounded-pill px-4" target="_blank">
                            <i class="bi bi-google-play me-2"></i>Unduh
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
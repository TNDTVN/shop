<?php require 'views/layouts/header.php'; ?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="display-5 fw-bold">Danh sách bài viết</h1>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/shop/?controller=product&action=edit" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Thêm bài viết mới
            </a>
        <?php endif; ?>
    </div>

    <?php if (empty($products)): ?>
        <div class="alert alert-info text-center py-4">
            <i class="bi bi-info-circle-fill" style="font-size: 2rem;"></i>
            <h4 class="mt-3">Chưa có bài viết nào</h4>
            <p class="mb-0">Hãy là người đầu tiên đăng bài viết!</p>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/shop/?controller=product&action=edit" class="btn btn-primary mt-3">
                    <i class="bi bi-plus-circle"></i> Thêm bài viết
                </a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($products as $product): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <?php if ($product['image']): ?>
                            <div class="product-image-container" style="height: 200px; overflow: hidden;">
                                <img src="/shop/public/images/<?php echo htmlspecialchars($product['image']); ?>"
                                    class="card-img-top h-100 object-fit-cover"
                                    alt="<?php echo htmlspecialchars($product['title']); ?>">
                            </div>
                        <?php else: ?>
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                            </div>
                        <?php endif; ?>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['title']); ?></h5>
                            <p class="card-text text-muted flex-grow-1">
                                <?php echo htmlspecialchars(substr($product['description'], 0, 100)); ?>
                                <?php if (strlen($product['description']) > 100): ?>...<?php endif; ?>
                            </p>

                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <a href="/shop/?controller=product&action=show&id=<?php echo $product['id']; ?>"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye"></i> Xem chi tiết
                                </a>

                                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $product['user_id']): ?>
                                    <a href="/shop/?controller=product&action=edit&id=<?php echo $product['id']; ?>"
                                        class="btn btn-outline-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Sửa
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="card-footer bg-transparent border-top-0">
                            <small class="text-muted">
                                <i class="bi bi-clock"></i> <?php echo date('d/m/Y', strtotime($product['created_at'])); ?>
                            </small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require 'views/layouts/footer.php'; ?>
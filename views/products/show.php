<?php require 'views/layouts/header.php'; ?>

<div class="container py-5">
    <!-- Product Section -->
    <div class="card mb-5 border-0 shadow-sm">
        <div class="row g-0">
            <!-- Product Image -->
            <div class="col-md-6 p-4 d-flex align-items-center bg-light">
                <?php if ($product['image']): ?>
                    <img src="/shop/public/images/<?php echo htmlspecialchars($product['image']); ?>"
                        class="img-fluid rounded mx-auto d-block product-image"
                        alt="<?php echo htmlspecialchars($product['title']); ?>"
                        style="max-height: 500px; object-fit: contain;">
                <?php else: ?>
                    <div class="text-center text-muted w-100">
                        <i class="bi bi-image" style="font-size: 5rem;"></i>
                        <p>Không có hình ảnh</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Product Details -->
            <div class="col-md-6">
                <div class="card-body p-4">
                    <h1 class="card-title mb-3"><?php echo htmlspecialchars($product['title']); ?></h1>

                    <div class="mb-4">
                        <p class="card-text text-muted"><?php echo htmlspecialchars($product['description']); ?></p>
                    </div>

                    <div class="d-flex justify-content-between align-items-center border-top pt-3">
                        <small class="text-muted">Đăng ngày: <?php echo date('d/m/Y', strtotime($product['created_at'])); ?></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <h3 class="card-title mb-4">
                <i class="bi bi-chat-left-text"></i> Bình luận
                <span class="badge bg-secondary ms-2"><?php echo count($comments); ?></span>
            </h3>

            <!-- Comment List -->
            <div class="mb-4">
                <?php if (empty($comments)): ?>
                    <div class="alert alert-info">Chưa có bình luận nào. Hãy là người đầu tiên bình luận!</div>
                <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="card mb-3 border-0" id="comment-<?php echo $comment['id']; ?>">
                            <div class="card-body <?php echo (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $comment['user_id']) ? 'bg-light' : ''; ?>">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <strong class="text-primary"><?php echo htmlspecialchars($comment['name']); ?></strong>
                                    <small class="text-muted">
                                        <?php echo date('H:i d/m/Y', strtotime($comment['created_at'])); ?>
                                        <?php if (!empty($comment['updated_at'])): ?>
                                            <span class="text-muted small">(sửa lúc: <?php echo date('H:i d/m/Y', strtotime($comment['updated_at'])); ?>)</span>
                                        <?php endif; ?>
                                    </small>
                                </div>

                                <?php if (isset($_GET['edit_comment_id']) && $_GET['edit_comment_id'] == $comment['id'] && isset($_SESSION['user_id']) && $_SESSION['user_id'] == $comment['user_id']): ?>
                                    <form method="POST" action="/shop/?controller=comment&action=edit">
                                        <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                                        <div class="mb-3">
                                            <textarea class="form-control" name="content" rows="3" required><?php echo htmlspecialchars($comment['content']); ?></textarea>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
                                            <a href="/shop/?controller=product&action=show&id=<?php echo $product['id']; ?>" class="btn btn-outline-secondary btn-sm">Hủy</a>
                                        </div>
                                    </form>
                                <?php else: ?>
                                    <p class="mb-2"><?php echo htmlspecialchars($comment['content']); ?></p>
                                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $comment['user_id']): ?>
                                        <div class="mt-2">
                                            <a href="/shop/?controller=comment&action=edit&id=<?php echo $comment['id']; ?>" class="btn btn-outline-warning btn-sm">Sửa</a>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Comment Form -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="card border-0 bg-light">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Viết bình luận</h5>
                        <form method="POST" action="/shop/?controller=comment&action=add">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <div class="mb-3">
                                <textarea class="form-control" name="content" rows="4" required placeholder="Viết bình luận của bạn tại đây..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-warning">
                    Bạn cần <a href="/shop/?controller=user&action=login" class="alert-link">đăng nhập</a> để bình luận.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require 'views/layouts/footer.php'; ?>
<?php require 'views/layouts/header.php'; ?>
<h2 class="mb-4"><?php echo $product ? 'Sửa bài viết' : 'Thêm bài viết'; ?></h2>
<div class="row justify-content-center">
    <div class="col-md-6">
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Tiêu đề</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $product ? htmlspecialchars($product['title']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control" id="description" name="description" rows="5" required><?php echo $product ? htmlspecialchars($product['description']) : ''; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Ảnh</label>
                <input type="file" class="form-control" id="image" name="image">
                <?php if ($product && $product['image']): ?>
                    <img src="/shop/public/images/<?php echo htmlspecialchars($product['image']); ?>" class="img-thumbnail mt-2" width="100" alt="Current image">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
        </form>
    </div>
</div>
<?php require 'views/layouts/footer.php'; ?>
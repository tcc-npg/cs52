<?= $this->extend('default'); ?>
<?= $this->section('pageTitle'); ?>- Inventory System | Dashboard<?= $this->endSection('pageTitle'); ?>
<?= $this->section('content'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Inventory System /</span> Dashboard</h4>
    <div class="card">
        <h5 class="card-header">Books</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <caption class="ms-4">
                    Count: <?php echo count($books); ?>
                </caption>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Author</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($books as $book): ?>
                        <tr>
                            <td><?php echo $book['book_name']; ?></td>
                            <td><?php echo $book['author']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>
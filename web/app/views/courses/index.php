<?php
$currPage = $_GET['page'] ?? 1;
$pagesCount = $data['pagesCount'];
$itemsCount = $data['itemsCount'];
$cards = $data['cards'];
?>
<div class="profile d-flex justify-content-center align-content-center h-100">
    <div class="bg-body w-75 px-5">
        <!-- Added px-5 for horizontal padding -->
        <div class="container my-5 d-flex flex-column">
            <h1 class="text-center" style="font-size: 2.5rem;">Daftar Kursus</h1>
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'instructor') : ?>
            <a href="<?= BASEURL ?>/courses/create" class="btn btn-primary ms-auto">Create New Course</a>
            <?php endif; ?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mt-1">
                <!-- Generate course cards from db -->
                <?php for ($i = 0; $i < $itemsCount; $i++) : ?>
                <!-- init card data -->
                <?php
                    $card = $cards["$i"];
                    $courseId = $card['id'];
                    $title = $card['title'];
                    $author = $card['first_name'] || $card['last_name'] ? $card['first_name'] . ' ' . $card['last_name'] : $card['username'];
                    $thumbnail = $card['thumbnail_url'] ?? 'default-thumbnail.webp';
                    ?>
                <div class="col mb-4">
                    <div class="card bg-light h-100">
                        <img src="<?= BASEURL ?>/img/thumbnail/<?= $thumbnail ?>" class="card-img-top"
                            alt="<?= $title ?>" style="height: 180px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title" style="font-size: 1.4rem;"><?= $title ?></h5>
                            <p class="author text-muted" style="font-size: 1.1rem;">Author: <?= $author ?></p>
                        </div>
                        <div class="card-footer bg-transparent border-0 text-center pb-4">
                            <a href="<?= BASEURL ?>/courses/enroll?courseId=<?= $courseId ?>"
                                class="btn btn-primary w-75 mb-2" style="font-size: 1.1rem;">Enroll me in this
                                course</a>
                            <a href="<?= BASEURL ?>/courses/detail?courseId=<?= $courseId ?>"
                                class="btn btn-outline-primary w-75">Details</a>
                        </div>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <a id="prev" class="page-link" href="?page=<?= $currPage - 1 ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php for ($i = 1; $i <= $pagesCount; $i++): ?>
                    <li id="<?= $i ?>" class="page-item"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
                    <?php endfor; ?>
                    <li class="page-item">
                        <a id="next" class="page-link" href="?page=<?= $currPage + 1 ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<script>
var currPage = <?= $currPage ?>;
var currentPageNumber = parseInt(currPage);
var totalPages = <?= $pagesCount ?>;

$('#' + currPage).addClass('active');

// Logic to disable the 'Previous' button
if (currentPageNumber <= 1) {
    // Add Bootstrap's 'disabled' class to the parent <li> element
    $('#prev').parent().addClass('disabled');
    // Make the link non-focusable for users navigating with keyboard
    $('#prev').attr('tabindex', '-1');
    // For accessibility: indicate that the element is disabled
    $('#prev').attr('aria-disabled', 'true');
} else {
    // Ensure it's not disabled if currPage is greater than 1
    $('#prev').parent().removeClass('disabled');
    $('#prev').removeAttr('tabindex'); // Re-enable focusability
    $('#prev').attr('aria-disabled', 'false');
}

// Logic to disable the 'Next' button
if (currentPageNumber >= totalPages) {
    // Add Bootstrap's 'disabled' class to the parent <li> element
    $('#next').parent().addClass('disabled');
    // Make the link non-focusable
    $('#next').attr('tabindex', '-1');
    // For accessibility
    $('#next').attr('aria-disabled', 'true');
} else {
    // Ensure it's not disabled if currPage is less than totalPages
    $('#next').parent().removeClass('disabled');
    $('#next').removeAttr('tabindex'); // Re-enable focusability
    $('#next').attr('aria-disabled', 'false');
}
</script>
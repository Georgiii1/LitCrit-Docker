<?php
// include("./database/connection.php");
// include("../admin-control/includes.php");


$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$userId = isset($_SESSION['user']['userID']) ? $_SESSION['user']['userID'] : null;
?>
<link href="fontawesome-6.7.2/css/fontawesome.css" rel="stylesheet" />
<link href="fontawesome-6.7.2/css/brands.css" rel="stylesheet" />
<link href="fontawesome-6.7.2/css/solid.css" rel="stylesheet" />


<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>


<link href="fonts/AdventPro/css2.css?family=Advent+Pro:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

<!--
    <link href="https://fonts.googleapis.com/css2?family=Advent+Pro:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    -->

<!--
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&display=swap" rel="stylesheet">
    -->

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="fonts/Caveat/css2.css?family=Caveat:wght@400..700&display=swap" rel="stylesheet">


<link href="bootstrap-5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="bootstrap-5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<link rel="stylesheet" href="./styles/styles.css">

<script src="jQuery-3.2.1/jquery-3.2.1.min.js"></script>

<?php include("elements/signup-login.php") ?>


<!-- Header 1 -->
<div class="row header">

  <div class="col-xl-3 col-lg-2">
    <a href="index.php"><img src="pictures/logo.png" alt="logo" style="width: 40%; height: 40%;"></a>
  </div>

  <div class="col-xl-4 col-lg-4">
    <form id="searchForm" method="POST" autocomplete="off">
      <div style="position:absolute;">
        <button class="search-btn" type="submit" style="position:relative; left:-32px; top:8px;">
          <i class="fa-solid fa-magnifying-glass fa-xl" style="color:#d45414;"></i>
        </button>
      </div>
      <input class="search-input" id="searchInput" name="search" type="text" autocomplete="off" placeholder="Търсене..">
      <div id="searchResults" class="search-results-container" style="display:none;"></div>
    </form>
  </div>


  <div class="col-xl-5 col-lg-6">
    <div class="dropdown-profile">
      <button class="dropbtn"><img width="44.5" style="border-radius: 50%; position:relative; left:-0.2px;"
          src="images/usersPfp/<?= isset($user['profilePicture']) && $user['profilePicture'] ? htmlspecialchars($user['profilePicture']) : 'default-profile-picture.png' ?>"></button>
      <div class="drop-content">
        <a href="index.php">Начало</a>
        <a href="my-reviews.php" <?php if (!isset($_SESSION['user'])) { ?>onclick="togglePopup(); return false;" <?php } ?>>Моите
          отзиви</a> <!-- togglePopup if the user is not logged in and don't open page-->
        <a href="my-books.php" <?php if (!isset($_SESSION['user'])) { ?>onclick="togglePopup(); return false;" <?php } ?>>Моите
          книги</a> <!-- togglePopup if the user is not logged in-->
        <a href="account.php" <?php if (!isset($_SESSION['user'])) { ?>onclick="togglePopup(); return false;" <?php } ?>>Профил</a>
        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') { ?>
          <a href="./admin-control/dashboard/index.php">Admin</a>
        <?php } ?>
      </div>
    </div>



    <div class="dropdown-genres">
      <button class="dropbtn"><i class="fa-solid fa-book-open fa-rotate-by fa-xl"
          style="color: #d45414; --fa-rotate-angle: 3deg;"></i></button>
      <div class="drop-content">

        <?php
        $stmt = $connection->prepare("select * from genre");
        $stmt->execute();
        $genres = $stmt->fetchAll();

        foreach ($genres as $genre) {

          ?>
          <a href="book-genres.php?genreID=<?= $genre["genreID"]; ?>"><?= $genre["bookGenre"]; ?></a>
        <?php } ?>

      </div>
    </div>

    <div class="btn-add-book">



      <!-- show login/signup popup -->
      <a href="add-book.php">
        <button class="add-book-btn" <?php if (!$user) { ?> onclick="togglePopup(); return false;" <?php } ?>
          data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-placement="bottom"
          title="Добавете книга"><i class="fa-solid fa-plus fa-xl" style="color: #d45414;"></i></button>
      </a>

    </div>
  </div>

</div>


<!-- Header 2 -->
<div class="row header2">

  <nav class="navbar navbar-expand-lg navcustom2">
    <div class="container-fluid fluidcustom2">

      <div class="col-xl-3 col-lg-3 navcustom">
        <a href="./index.php"><img class="header2-logo" src="pictures/logo.png" alt="logo"></a>

        <div class="navbar-toggler-button" id="mobilebtn">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>

      </div>
      <?php
      $stmt = $connection->prepare("select * from genre");
      $stmt->execute();
      $genres = $stmt->fetchAll();
      ?>
      <div class="collapse navbar-collapse collapse2" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Жанрове
            </a>
            <ul class="dropdown-menu">
              <?php foreach ($genres as $genre): ?>
                <li>
                  <a class="dropdown-item" href="book-genres.php?genreID=<?= $genre["genreID"]; ?>">
                    <?= $genre["bookGenre"]; ?>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </li>


          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="add-book.php" <?php if (!$user) { ?>
                onclick="togglePopup(); return false;" <?php } ?>>Добавете книга</a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              За мен
            </a>

            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="index.php">Начало</a></li>
              <li><a class="dropdown-item" href="my-reviews.php" <?php if (!isset($_SESSION['user'])) { ?>onclick="togglePopup(); return false;" <?php } ?>>Моите
                  отзиви</a></li>
              <!-- togglePopup if the user is not logged in and don't open page-->
              <li><a class="dropdown-item" href="my-books.php" <?php if (!isset($_SESSION['user'])) { ?>onclick="togglePopup(); return false;" <?php } ?>>Моите
                  книги</a></li>
              <!-- togglePopup if the user is not logged in and don't open page-->
              <li><a class="dropdown-item" href="account.php" <?php if (!isset($_SESSION['user'])) { ?>onclick="togglePopup(); return false;" <?php } ?>>Профил</a></li>
              <!-- togglePopup if the user is not logged in and don't open page-->
              <li>
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') { ?>
                  <a class="dropdown-item" href="./admin-control/dashboard/index.php">Admin</a>
                <?php } ?>
              </li>
            </ul>
          </li>

        </ul>


        <form class="d-flex" id="navbarSearchForm" role="search" method="POST" autocomplete="off"
          style="position:relative;">
          <div style="position:absolute;">
            <button class="search-btn" type="submit" style="position:relative; left:-5px; top: 8px;">
              <i class="fa-solid fa-magnifying-glass fa-xl" style="color: #d45414;"></i>
            </button>
          </div>
          <input class="search-input" id="navbarSearchInput" name="search" type="text" placeholder="Търсене..."
            autocomplete="off" style="margin-left: 29px;">
          <div id="navbarSearchResults" class="search-results-container"
            style="display:none; position:absolute; top:40px; left:0; z-index:9999; width:100%;"></div>
        </form>
        <script>
          var X = false;
          function setupSearchBar(inputSelector, resultsSelector, formSelector) {
            const $input = $(inputSelector);
            const $results = $(resultsSelector);
            const $form = $(formSelector);

            function renderResults(data) {
              $results.empty().append('<div class="search-section-title">Книги</div>');
              if (data.success && data.books.length) {
                data.books.forEach(book => {
                  $results.append(`
                    <div class="search-result-item" data-id="${book.bookID}">
                      <img src="./images/covers/${book.bookCover}" alt="${book.bookTitle}" class="book-image">
                      <div class="book-info">
                        <a href="book-details.php?id=${book.bookID}" class="book-title">${book.bookTitle}</a>
                        <p class="book-author">от ${book.bookAuthor}</p>
                      </div>
                    </div>
                  `);
                });
              } else {
                $results.append('<div class="no-results">Няма книги съвпадащи с вашето търсене.</div>');
              }
              $results.show();
            }

            $input.on('input', function () {
              if (!X) {
                setTimeout(() => {
                  X = false;
                  const query = $input.val().trim();
                  if (query.length < 2) return $results.hide().empty();
                  $.get('elements/get_search_results.php', { q: query }, renderResults, 'json');
                }, 2000);
              }

            });

            $results.on('mousedown', '.search-result-item', function () {
              window.location = 'book-details.php?id=' + $(this).data('id');
            });

            $(document).on('mousedown', function (e) {
              if (!$(e.target).closest(formSelector).length) $results.hide();
            });

            $form.on('submit', function (e) {
              e.preventDefault();
              $input.trigger('input');
            });
          }

          $(function () {
            setupSearchBar('#searchInput', '#searchResults', '#searchForm');
            setupSearchBar('#navbarSearchInput', '#navbarSearchResults', '#navbarSearchForm');
          });
        </script>

      </div>
    </div>
  </nav>



  <!-- headers JS -->
  <script>
    let lastScrollTop = 0;
    const header = document.querySelector('.header');

    window.addEventListener('scroll', () => {
      const currentScroll = window.pageYOffset || document.documentElement.scrollTop;

      if (currentScroll > lastScrollTop) {
        header.style.transform = 'translateY(-100%)';
      } else {
        header.style.transform = 'translateY(0)';
      }

      lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
    });


    let lastScrollTop2 = 0;
    const header2 = document.querySelector('.header2');

    window.addEventListener('scroll', () => {
      const currentScroll2 = window.pageYOffset || document.documentElement.scrollTop;

      if (currentScroll2 > lastScrollTop2) {
        header2.style.transform = 'translateY(-100%)';
      } else {
        header2.style.transform = 'translateY(0)';
      }

      lastScrollTop2 = currentScroll2 <= 0 ? 0 : currentScroll2;
    });
  </script>

</div>
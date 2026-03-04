<?php

$isLoggedIn = Auth::isLoggedIn();
$currentUser = Auth::currentUser();

$gamesPayload = array_map(function (array $game): array {
    $picture = trim((string)($game['picture'] ?? ''));
    if ($picture === '') {
        $picture = 'jeux/animalcrossing.jpg';
    } elseif (!str_contains($picture, '/')) {
        $picture = 'jeux/' . $picture;
    }

    return [
        'id' => (int)$game['id'],
        'image' => $picture,
        'title' => (string)($game['name'] ?? 'Jeu'),
        'genre' => (string)($game['genre'] ?? 'Jeu'),
        'year' => (int)($game['year'] ?? 0),
        'rating' => (float)($game['rating'] ?? 0),
        'desc' => (string)($game['description'] ?? 'Description indisponible.'),
        'price' => (float)($game['price'] ?? 0),
        'levels' => [],
        'trophies' => [],
    ];
}, $games);

$ownedIds = array_map('intval', $ownedGameIds ?? []);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shinook – Ta bibliothèque de jeux</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Fredoka+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<div class="leaf-bg" id="leafBg"></div>

<nav>
    <a href="<?= BASE_URL ?>game.php" class="nav-logo">
        <img src="icons/Shinook.png" alt="Shinook" class="logo">
        Shinook
    </a>
    <ul class="nav-links">
        <li><a href="<?= BASE_URL ?>game.php" class="active">Accueil</a></li>
        <li><a href="<?= BASE_URL ?>profile.php">Profil</a></li>
        <?php if ($isLoggedIn): ?>
            <li><a href="<?= BASE_URL ?>logout.php" class="btn-nav">Se déconnecter</a></li>
        <?php else: ?>
            <li><a href="<?= BASE_URL ?>login.php" class="btn-nav">Se connecter</a></li>
        <?php endif; ?>
    </ul>
</nav>

<section class="hero">
    <div class="hero-badge">Bienvenue sur l'île</div>
    <h1>Ta biblio de jeux,<br><span>style Deserted Island ✨</span></h1>
    <p>Découvre tous les jeux de la plateforme, ajoute tes favoris à ta bibliothèque et collectionne des trophées !</p>
</section>

<?php if (!$isLoggedIn): ?>
    <div class="login-banner">
        <div class="banner-box">
            <img src="stickers/nook.png" alt="Nook" class="b-icon">
            <div class="b-text">
                <strong>Connecte-toi pour plus de fun !</strong>
                <span>Ajoute des jeux à ta bibliothèque, gagne des trophées, et personnalise ton île.</span>
            </div>
            <a href="<?= BASE_URL ?>login.php">Rejoindre l'île →</a>
        </div>
    </div>
<?php endif; ?>

<div class="filter-bar">
    <div class="search-wrap">
        <span class="search-icon">🔍</span>
        <input type="text" id="searchInput" placeholder="Chercher un jeu…">
    </div>
    <div class="filter-pills">
        <button class="pill active" data-filter="all">Tous</button>
        <?php
        $genres = array_values(array_unique(array_map(static fn($game) => (string)$game['genre'], $gamesPayload)));
        sort($genres);
        foreach ($genres as $genre):
            ?>
            <button class="pill" data-filter="<?= htmlspecialchars($genre) ?>"><?= htmlspecialchars($genre) ?></button>
        <?php endforeach; ?>
    </div>
</div>

<section class="section">
    <h2 class="section-title">Tous les jeux</h2>
    <div class="games-grid" id="gamesGrid"></div>
</section>

<div class="modal-overlay" id="modalOverlay">
    <div class="modal-scroll">
        <div class="modal" id="modal">
            <div class="modal-header" id="modalHeader">
                <button class="modal-close" id="modalClose">✕</button>
                <img id="modalCover" class="modal-cover" src="jeux/animalcrossing.jpg" alt="Couverture du jeu">
            </div>
            <div class="modal-body">
                <span class="modal-genre" id="modalGenre">Aventure</span>
                <div class="modal-title" id="modalTitle">Nom du jeu</div>
                <div class="modal-stats" id="modalStats"></div>
                <p class="modal-desc" id="modalDesc">Description du jeu…</p>
                <div class="modal-levels" id="modalLevels"></div>
                <div class="modal-trophies" id="modalTrophies"></div>
                <div class="modal-actions" id="modalActions"></div>
            </div>
        </div>
    </div>
</div>

<div class="toast" id="toast"></div>

<footer>
    <strong>Shinook</strong> — Fait par Elisabeth ROBL, Léna Ricard et Emma De Oliveira &nbsp;|&nbsp; Tom Nook vous surveille 🦝
</footer>

<script src="js/stickers.js"></script>
<script>
    const GAMES = <?= json_encode($gamesPayload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
    const userLibrary = new Set(<?= json_encode($ownedIds, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>);
    const isLoggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;

    initFloatingStickers({ count: 18 });

    let activeFilter = 'all';
    document.querySelectorAll('.pill').forEach((pill) => {
        pill.addEventListener('click', () => {
            document.querySelectorAll('.pill').forEach((item) => item.classList.remove('active'));
            pill.classList.add('active');
            activeFilter = pill.dataset.filter;
            renderGames();
        });
    });
    document.getElementById('searchInput').addEventListener('input', renderGames);

    function renderGames() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const grid = document.getElementById('gamesGrid');
        const filtered = GAMES.filter((game) => {
            const matchFilter = activeFilter === 'all' || game.genre === activeFilter;
            const matchSearch = game.title.toLowerCase().includes(query)
                || game.desc.toLowerCase().includes(query)
                || game.genre.toLowerCase().includes(query);
            return matchFilter && matchSearch;
        });

        grid.innerHTML = '';
        if (!filtered.length) {
            grid.innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:3rem;color:var(--text-light);font-size:1.1rem;font-weight:700;">Aucun jeu trouvé<br><small style="font-size:0.85rem;font-weight:600;">Essaie un autre terme ou filtre.</small></div>';
            return;
        }

        filtered.forEach((game, index) => {
            const inLibrary = userLibrary.has(game.id);
            const card = document.createElement('div');
            card.className = 'game-card' + (inLibrary ? ' in-library' : '');
            card.style.animationDelay = (index * 0.05) + 's';
            card.innerHTML = `
            <img class="card-thumb" src="${game.image}" alt="${game.title}">
            <div class="card-body">
                <span class="card-genre">${game.genre}</span>
                <div class="card-title">${game.title}</div>
                <div class="card-meta">
                    <span class="card-stars">${'★'.repeat(Math.round(game.rating))}${'☆'.repeat(5 - Math.round(game.rating))}</span>
                    <span>${game.rating} · ${game.year}</span>
                </div>
            </div>`;
            card.addEventListener('click', () => openModal(game));
            grid.appendChild(card);
        });
    }

    function openModal(game) {
        const inLibrary = userLibrary.has(game.id);
        document.getElementById('modalCover').src = game.image;
        document.getElementById('modalCover').alt = game.title;
        document.getElementById('modalGenre').textContent = game.genre;
        document.getElementById('modalTitle').textContent = game.title;
        document.getElementById('modalDesc').textContent = game.desc || 'Description indisponible.';

        document.getElementById('modalStats').innerHTML = `
        <div class="modal-stat"><span class="s-val">${game.rating}</span><span class="s-lbl">Note</span></div>
        <div class="modal-stat"><span class="s-val">${game.year}</span><span class="s-lbl">Sortie</span></div>
        <div class="modal-stat"><span class="s-val">${game.price.toFixed(2)}€</span><span class="s-lbl">Prix</span></div>`;

        document.getElementById('modalLevels').innerHTML = '';
        document.getElementById('modalTrophies').innerHTML = '';

        let actionsHTML = '';
        if (!isLoggedIn) {
            actionsHTML = `
            <a href="<?= BASE_URL ?>login.php" class="btn-primary" style="text-decoration:none">Se connecter pour ajouter</a>
            <button class="btn-secondary" onclick="closeModal()">Fermer</button>`;
        } else if (inLibrary) {
            actionsHTML = `
            <div class="already-added">Déjà dans ta bibliothèque</div>
            <button class="btn-danger" onclick="submitUserGame('remove', ${game.id})">Retirer</button>
            <button class="btn-secondary" onclick="closeModal()">Fermer</button>`;
        } else {
            actionsHTML = `
            <button class="btn-primary" onclick="submitUserGame('add', ${game.id})">Ajouter à ma bibliothèque</button>
            <button class="btn-secondary" onclick="closeModal()">Fermer</button>`;
        }
        document.getElementById('modalActions').innerHTML = actionsHTML;

        document.getElementById('modalOverlay').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('modalOverlay').classList.remove('open');
        document.body.style.overflow = '';
    }

    function submitUserGame(action, gameId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= BASE_URL ?>usergame.php';

        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action';
        actionInput.value = action;

        const gameInput = document.createElement('input');
        gameInput.type = 'hidden';
        gameInput.name = 'game_id';
        gameInput.value = String(gameId);

        const redirectInput = document.createElement('input');
        redirectInput.type = 'hidden';
        redirectInput.name = 'redirect';
        redirectInput.value = 'game.php';

        form.appendChild(actionInput);
        form.appendChild(gameInput);
        form.appendChild(redirectInput);
        document.body.appendChild(form);
        form.submit();
    }

    document.getElementById('modalClose').addEventListener('click', closeModal);
    document.getElementById('modalOverlay').addEventListener('click', (event) => {
        if (event.target === document.getElementById('modalOverlay')) closeModal();
    });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') closeModal();
    });

    renderGames();
</script>
</body>
</html>


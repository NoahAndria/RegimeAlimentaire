<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diet Balance</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="/assets/css/hero.css" rel="stylesheet">
</head>
<body class="hero-page">
    <main class="hero">
        <section class="hero-copy">
            <div class="hero-kicker">Diet Balance</div>
            <h1>Diet Balance, votre solution pour vos objectifs de poids</h1>
            <p>
                Choisissez un parcours clair, adapte a votre rythme et suivez des recommandations
                simples pour avancer chaque jour.
            </p>
            <div class="hero-actions">
                <a class="hero-btn hero-btn-large" href="/regime/perdre">Perdre du poids</a>
                <a class="hero-btn hero-btn-secondary hero-btn-medium" href="/regime/gagner">Gagner du Poids</a>
                <a class="hero-btn hero-btn-ghost hero-btn-small" href="/regime/imc">Atteindre son IMC</a>
            </div>
        </section>

        <aside class="hero-card" aria-hidden="true">
            <div class="card-glow"></div>
            <div class="card-head">
                <span class="pill">Progression</span>
                <span class="pill pill-light">Equilibre</span>
            </div>
            <div class="card-title">Votre trajectoire en un coup d'oeil</div>
            <div class="card-lines">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="card-metrics">
                <div>
                    <strong>12</strong>
                    <span>semaines</span>
                </div>
                <div>
                    <strong>3</strong>
                    <span>objectifs</span>
                </div>
                <div>
                    <strong>100%</strong>
                    <span>suivi</span>
                </div>
            </div>
        </aside>
    </main>

    <section class="hero-redeem">
        <div class="redeem-card">
            <div>
                <span class="redeem-kicker">Recharge rapide</span>
                <h2>Ajoutez un code pour alimenter votre balance</h2>
                <p>Utilisez un code valide pour augmenter votre solde en quelques secondes.</p>
            </div>
            <a class="redeem-btn" href="/code/redeem">Utiliser un code</a>
        </div>
    </section>

    <section class="hero-offers">
        <div class="offers-head">
            <div>
                <span class="offers-kicker">Offres</span>
                <h2>Choisissez votre option</h2>
                <p>Payez en une seule fois et profitez des avantages de l'offre choisie.</p>
            </div>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('erreur')): ?>
            <div class="alert alert-error">
                <?= esc(session()->getFlashdata('erreur')) ?>
            </div>
        <?php endif; ?>

        <?php if (empty($options)): ?>
            <div class="empty-state">Aucune offre disponible.</div>
        <?php else: ?>
            <div class="offers-grid">
                <?php foreach ($options as $option): ?>
                    <article class="offer-card">
                        <div>
                            <div class="offer-title"><?= esc($option['label']) ?></div>
                            <div class="offer-meta">
                                <span class="offer-price"><?= esc($option['prix']) ?> $</span>
                                <span class="offer-reduction">Reduction <?= esc($option['reduction']) ?> %</span>
                            </div>
                        </div>
                        <form action="/options/acheter" method="POST">
                            <?= csrf_field() ?>
                            <input type="hidden" name="option_id" value="<?= esc($option['id']) ?>">
                            <button type="submit" class="offer-btn">Acheter</button>
                        </form>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</body>
</html>

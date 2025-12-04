<?php
// Partial que renderiza a grade de restaurantes. Espera $restaurantes e $placeholderImage.
$referer = $_SERVER['HTTP_REFERER'] ?? '';
$detailsPath = (strpos($referer, '/cliente/') !== false) ? 'detalhes.php' : 'detalhes-publico.php';
?>
<?php if (empty($restaurantes)): ?>
    <p style="color: var(--text-secondary); text-align:center; width: 100%;">Nenhum restaurante cadastrado no momento.</p>
<?php else: ?>
    <?php foreach ($restaurantes as $restaurante): ?>
        <?php
        $imagem = $restaurante['imagem'] ? htmlspecialchars($restaurante['imagem']) : $placeholderImage;
        $descricaoCurta = $restaurante['descricao'] ? mb_strimwidth($restaurante['descricao'], 0, 120, '...') : 'Descrição não informada ainda.';
        $caracteristicas = $restaurante['caracteristicas'] ?? [];
        ?>
        <div class="restaurant-card" data-href="<?php echo $detailsPath; ?>?id=<?php echo $restaurante['id']; ?>">
            <div class="restaurant-image" style="background-image: url('<?php echo $imagem; ?>');"></div>
            <div class="restaurant-info">
                <h3 class="restaurant-name"><?php echo htmlspecialchars($restaurante['nome']); ?></h3>
                <p class="restaurant-category"><?php echo htmlspecialchars($restaurante['categoria'] ?? 'Categoria não informada'); ?></p>
                <p class="restaurant-location">📍 <?php echo htmlspecialchars($restaurante['endereco_formatado']); ?></p>
                <p class="restaurant-description"><?php echo htmlspecialchars($descricaoCurta); ?></p>
                <?php if (!empty($restaurante['rating_count'])): ?>
                    <?php $avg = number_format((float)($restaurante['rating_medio'] ?? 0), 1); $filled = (int) round($restaurante['rating_medio'] ?? 0); ?>
                    <div class="restaurant-rating">
                        <span class="stars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?php echo $i <= $filled ? '★' : '☆'; ?>
                            <?php endfor; ?>
                        </span>
                        <span class="rating-text"><?php echo $avg; ?> (<?php echo (int)$restaurante['rating_count']; ?>)</span>
                    </div>
                <?php endif; ?>
                <?php if (!empty($caracteristicas)): ?>
                    <div class="restaurant-features">
                        <?php foreach (array_slice($caracteristicas, 0, 3) as $feature): ?>
                            <span class="feature-badge"><?php echo htmlspecialchars($feature); ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <div class="restaurant-actions">
                    <button class="btn btn-primary btn-small" onclick="event.stopPropagation(); makeReservation(<?php echo $restaurante['id']; ?>)">
                        Reservar Mesa
                    </button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

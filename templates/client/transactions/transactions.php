
<div class="transactions-section">
    <div class="transactions-title">Toutes les transactions (<?= $pagination['totalItems'] ?>)</div>
    <a href="/client/dashboard" class="see-more">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
</div>

<div class="transactions-list">
    <?php if (!empty($transactions)): ?>
        <?php foreach ($transactions as $transaction): ?>
            <div class="transaction-item">
                <div class="transaction-icon">
                    <i class="bi <?= $transaction->getTypeIcon() ?>"></i>
                </div>
                <div class="transaction-details">
                    <div class="transaction-title"><?= htmlspecialchars($transaction->getTypeLabel()) ?></div>
                    <div class="transaction-date">
                        <?= $transaction->getFormattedDate() ?>, 
                        <?= htmlspecialchars(number_format($transaction->getMontant(), 0, ',', ' ')) ?> FCFA
                    </div>
                </div>
                <div class="transaction-amount-container">
                    <div class="transaction-amount"><?= htmlspecialchars(number_format($transaction->getMontant(), 0, ',', ' ')) ?> FCFA</div>
                    <span class="transaction-badge <?= $transaction->getTypeBadgeClass() ?>">
                        <?= htmlspecialchars($transaction->getType()) ?>
                    </span>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="transaction-item">
            <div class="transaction-details">
                <div class="transaction-title">Aucune transaction</div>
                <div class="transaction-date">Vous n'avez pas encore effectué de transactions</div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php if ($pagination['totalPages'] > 1): ?>
    <div class="pagination">
        <?php if ($pagination['hasPrevious']): ?>
            <a href="?page=<?= $pagination['currentPage'] - 1 ?>" class="pagination-btn">
                <i class="bi bi-chevron-left"></i> Précédent
            </a>
        <?php endif; ?>
        
        <div class="pagination-info">
            Page <?= $pagination['currentPage'] ?> sur <?= $pagination['totalPages'] ?>
        </div>
        
        <?php if ($pagination['hasNext']): ?>
            <a href="?page=<?= $pagination['currentPage'] + 1 ?>" class="pagination-btn">
                Suivant <i class="bi bi-chevron-right"></i>
            </a>
        <?php endif; ?>
    </div>
<?php endif; ?>
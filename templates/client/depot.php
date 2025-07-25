<div class="depot-section">
    <h2>Déposer de l'argent</h2>
    <?php if (!empty($message)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" class="depot-form">
        <div class="form-group">
            <label for="montant">Montant à déposer (FCFA)</label>
            <input type="number" name="montant" id="montant" class="form-control" min="1" required>
        </div>
        <button type="submit" class="btn btn-primary">Déposer</button>
        <a href="/client/dashboard" class="btn btn-secondary">Annuler</a>
    </form>
</div>
<style>
    .depot-section { background: #fff; border-radius: 12px; padding: 32px; max-width: 400px; margin: 32px auto; }
    .depot-form .form-group { margin-bottom: 16px; }
    .depot-form label { font-weight: 500; }
    .depot-form input { width: 100%; padding: 8px; border-radius: 6px; border: 1px solid #ccc; }
    .btn { padding: 10px 20px; border-radius: 8px; margin-right: 8px; }
    .btn-primary { background: #ff8c00; color: #fff; border: none; }
    .btn-secondary { background: #eee; color: #333; border: none; }
    .alert { margin-bottom: 16px; padding: 10px; border-radius: 6px; }
    .alert-success { background: #e8f5e8; color: #2e7d32; }
    .alert-danger { background: #ffebee; color: #d32f2f; }
</style>

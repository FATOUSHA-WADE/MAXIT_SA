<div style="max-width: 600px; margin: 0 auto;">
    <a href="/client/dashboard" style="display: inline-flex; align-items: center; gap: 6px; color: #ff8c00; text-decoration: none; font-size: 1rem; font-weight: 500; margin-bottom: 24px;">
        <i class="bi bi-arrow-left"></i> Retour au dashboard
    </a>

    <h2 style="color: #ff8c00; font-size: 1.8rem; font-weight: 700; margin-bottom: 24px; text-align: center;">
        Dépôt par transfert
    </h2>

    <?php if ($this->session->get('success')): ?>
        <div style="background-color: #d4edda; color: #155724; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
            <?= $this->session->unset('success') ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->get('general_error')): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
            <?= $this->session->unset('general_error') ?>
        </div>
    <?php endif; ?>

    <div style="background: white; border-radius: 16px; box-shadow: 0 4px 16px rgba(0,0,0,0.08); padding: 32px;">
        <form method="POST" action="/client/depot-transfert" style="display: flex; flex-direction: column; gap: 24px;">
            
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <label for="telephone_destination" style="font-weight: 500; color: #333;">Numéro de téléphone de destination <span style="color: red;">*</span></label>
                <input type="text" id="telephone_destination" name="telephone_destination" 
                       value="<?= htmlspecialchars($old['telephone_destination'] ?? '') ?>"
                       class="search-input" placeholder="Entrez le numéro de téléphone" required 
                       style="padding: 12px; border-radius: 8px; border: 1.5px solid #ff8c00; font-size: 1rem;">
                <?php if (isset($this->session->get('field_errors')['telephone_destination'])): ?>
                    <span style="color: red; font-size: 0.875rem;">
                        <?= $this->session->get('field_errors')['telephone_destination'][0] ?>
                    </span>
                <?php endif; ?>
            </div>

            <div style="display: flex; flex-direction: column; gap: 8px;">
                <label for="montant" style="font-weight: 500; color: #333;">Montant <span style="color: red;">*</span></label>
                <input type="number" id="montant" name="montant" 
                       value="<?= htmlspecialchars($old['montant'] ?? '') ?>"
                       class="search-input" placeholder="Entrez le montant" required 
                       style="padding: 12px; border-radius: 8px; border: 1.5px solid #ff8c00; font-size: 1rem;">
                <?php if (isset($this->session->get('field_errors')['montant'])): ?>
                    <span style="color: red; font-size: 0.875rem;">
                        <?= $this->session->get('field_errors')['montant'][0] ?>
                    </span>
                <?php endif; ?>
            </div>

            <button type="submit" style="background-color: #ff8c00; color: white; padding: 14px 24px; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: background-color 0.2s;">
                Effectuer le dépôt par transfert
            </button>
        </form>
    </div>
</div>

<?php $this->session->unset('field_errors'); ?>
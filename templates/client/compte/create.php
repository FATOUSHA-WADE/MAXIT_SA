
<a href="/client/acountsList" style="display: inline-flex; align-items: center; gap: 6px; color: #ff8c00; text-decoration: none; font-size: 1rem; font-weight: 500; margin-bottom: 24px;">
            <i class="bi bi-arrow-left"></i> Retour à la liste des comptes
        </a>

<div style="display: flex; justify-content: center; align-items: center; width: 100%; min-height: 60vh;">
    <div style="  display:flex; flex-direction:column ; justify-content: center; align-items: center; background: #f1f1f1; border-radius: 16px; box-shadow: 0 4px 16px rgba(0,0,0,0.08); padding: 48px 40px; width: 100%; max-width: 60%;">
        <h2 style="text-align: center; color: #ff8c00; font-size: 2rem; font-weight: 700; margin-bottom: 32px;">Ajouter un compte secondaire</h2>
        
        <form method="POST" action="/client/create-account" style="display: flex; flex-direction: column; gap: 32px;width: 70%;">
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <label for="numero_telephone" style="font-weight: 500; color: #333;">Numéro de téléphone <span style="color: red;">*</span></label>
                <input type="text" id="numero_telephone" name="telephone" class="search-input" placeholder="Entrez le numéro de téléphone" required style="padding: 12px; border-radius: 8px; border: 1.5px solid #ff8c00; font-size: 1rem;">
            </div>
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <label for="solde" style="font-weight: 500; color: #333;">Solde initial (optionnel)</label>
                <input type="number" id="solde" name="solde" class="search-input" placeholder="Entrez le solde initial" style="padding: 12px; border-radius: 8px; border: 1.5px solid #ff8c00; font-size: 1rem;">
            </div>
            <button type="submit" style="background: linear-gradient(135deg, #ff8c00 0%, #fb923c 100%); color: #fff; font-weight: 600; border: none; border-radius: 8px; padding: 14px 0; font-size: 1.1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 8px; transition: background 0.2s;">
                <i class="bi bi-plus-circle"></i> Ajouter le compte
            </button>
        </form>
    </div>
</div>
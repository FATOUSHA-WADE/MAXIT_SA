<div class="bg-white rounded-lg shadow p-6 mb-6">
    <!-- En-tête -->
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center">
            <div class="pagination-btn w-10 h-10 rounded-full flex items-center justify-center mr-3">
                <i class="bi bi-wallet2 text-white"></i>
            </div>
            <h2 class="text-xl font-bold text-gray-800">Tous mes comptes (<?= $totalAccounts?>)</h2>
        </div>
        <a href="/client/create-account" class="pagination-btn text-white px-4 py-2 rounded-lg font-medium ">
            <i class="bi bi-plus-circle mr-2"></i>
            Nouveau compte
        </a>
    </div>

    <div class="space-y-4">
        <!-- Compte Principal -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center mb-2">
                        <h3 class="font-bold text-gray-800 mr-3">Compte Principal</h3>
                       
                    </div>
                    <p class="text-gray-600 text-sm">
                        <?php echo $primaryaccount->getNumeroTelephone(); ?> • Solde disponible
                    </p>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-gray-800">
                        <?php echo number_format($primaryaccount->getSolde(), 0, ',', ' '); ?>
                        <span class="text-lg text-gray-600">FCFA</span>
                    </div>
                    <div class="text-green-600 text-sm">Compte actuel</div>
                </div>
            </div>
        </div>

        <!-- Comptes Secondaires -->
        <?php if (isset($accounts) && count($accounts) > 0): ?>
            <?php foreach ($accounts as $account): ?>
                <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <h3 class="bg-green-200 text-black px-2 py-1 rounded text-xs font-medium">
                                    <?= htmlspecialchars($account->getTypeCompte()) ?>
                                </h3>
                               
                            </div>
                            <p class="text-gray-600 text-sm">
                                <?= htmlspecialchars($account->getNumeroTelephone()) ?> 
                            </p>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-gray-800 mb-2">
                                <?= htmlspecialchars(number_format($account->getSolde(), 0, ',', ' ')) ?>
                                <span class="text-lg text-gray-600">FCFA</span>
                            </div>
                            <form method="POST" action="/client/set-main-account" style="display: inline;">
                                <input type="hidden" name="compte_id" value="<?= $account->getId() ?>">
                                <button type="submit"  class="bg-green-200 text-black px-2 py-1 rounded text-xs font-medium">
                                    Définir comme principal
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- État vide -->
            <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                <div class="bg-gray-300 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-wallet2 text-gray-500 text-2xl"></i>
                </div>
                <h3 class="font-semibold text-gray-700 mb-2">Aucun compte secondaire</h3>
                <p class="text-gray-500 text-sm mb-4">Vous n'avez pas encore de compte secondaire</p>
                <a href="/client/create-account" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700 transition inline-flex items-center">
                    Créer mon premier compte
                </a>
            </div>
        <?php endif; ?>
        
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
    </div>
</div>
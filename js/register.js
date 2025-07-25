document.addEventListener('DOMContentLoaded', function() {
    console.log('Script chargé et exécuté !');
    
    // Vérifiez que les éléments sont trouvés
    console.log({
        cniInput: document.getElementById('numero_cni'),
        hiddenFields: document.getElementById('hiddenFields'),
        submitBtn: document.getElementById('submitBtn'),
        checkBtn: document.getElementById('checkCitizenBtn'),
        form: document.getElementById('registrationForm')
    });
    
    const cniInput = document.getElementById('numero_cni');
    const hiddenFields = document.getElementById('hiddenFields');
    const submitBtn = document.getElementById('submitBtn');
    const checkBtn = document.getElementById('checkCitizenBtn');
    const form = document.getElementById('registrationForm');
    const statusMessage = document.getElementById('statusMessage');
    
    // Fonction pour afficher les toasts
    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast');
        const toastContent = toast.querySelector('div');
        
        // Définir la couleur de la bordure selon le type
        const borderColor = type === 'success' ? 'border-green-500' : 'border-red-500';
        const bgColor = type === 'success' ? 'bg-green-50' : 'bg-red-50';
        const textColor = type === 'success' ? 'text-green-800' : 'text-red-800';
        
        toastContent.className = `p-4 ${borderColor} ${bgColor} ${textColor} rounded-lg shadow-lg`;
        toastContent.textContent = message;
        
        // Afficher le toast
        toast.classList.remove('hidden');
        
        // Cacher le toast après 3 secondes
        setTimeout(() => {
            toast.classList.add('hidden');
        }, 3000);
    }

    // Validation du numéro CNI
    function isValidCNI(cni) {
        return /^\d{13}$/.test(cni);
    }

    // Gestionnaire du bouton de vérification
    checkBtn.addEventListener('click', async function() {
        const cni = cniInput.value.trim();
        
        // Réinitialiser l'interface
        hiddenFields.classList.add('hidden');
        submitBtn.disabled = true;
        statusMessage.classList.add('hidden');
        
        // Vérifier le format CNI
        if (!isValidCNI(cni)) {
            showToast('Le numéro CNI doit contenir exactement 13 chiffres', 'error');
            return;
        }

        // Désactiver le bouton pendant la vérification
        checkBtn.disabled = true;
        checkBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Vérification...';

        try {
            // Utiliser la bonne URL
            const response = await fetch(`https://appdaf-0soa.onrender.com/citoyens/${cni}`);
            
            // Vérifier si la réponse est ok
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log('Données reçues:', data); // Pour debug

            // Vérifier la structure des données reçues
            if (data && data.data && data.data.nom && data.data.prenom) {
                // Obtenir les références des champs
                const nomInput = document.getElementById('nom');
                const prenomInput = document.getElementById('prenom');
                
                // Définir les valeurs (pas les placeholders)
                nomInput.value = data.data.nom;
                prenomInput.value = data.data.prenom;
                
                // S'assurer que les champs sont en lecture seule
                nomInput.readOnly = true;
                prenomInput.readOnly = true;
                
                // Afficher les champs cachés
                hiddenFields.classList.remove('hidden');
                submitBtn.disabled = false;
                
                showToast(' Citoyen trouvé');
                statusMessage.innerHTML = '<div class="text-green-600"><i class="bi bi-check-circle"></i> Citoyen vérifié avec succès</div>';
                statusMessage.classList.remove('hidden');
            } else {
                throw new Error('Format de données invalide');
            }
        } catch (error) {
            console.error('Erreur:', error); // Pour debug
            showToast(' Aucun citoyen trouvé avec ce numéro de CNI', 'error');
            statusMessage.innerHTML = '<div class="text-red-600"><i class="bi bi-x-circle"></i> Aucun citoyen trouvé</div>';
            statusMessage.classList.remove('hidden');
        } finally {
            // Réactiver le bouton
            checkBtn.disabled = false;
            checkBtn.innerHTML = '<i class="bi bi-search"></i> Vérifier le citoyen';
        }
    });

    // Validation du formulaire
    form.addEventListener('submit', function(e) {
        const cni = cniInput.value.trim();
        if (!isValidCNI(cni)) {
            e.preventDefault();
            showToast('Numéro CNI invalide', 'error');
        }
    });
});
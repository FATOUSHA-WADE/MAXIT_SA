<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire CNI - Version Corrigée</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .input-focus:focus {
            outline: none;
            border-color: #ea580c;
            box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.1);
        }
        .container-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>
<body class="bg-gray-50 py-8">
    <!-- Toast container -->
    <div id="toast" class="fixed top-4 right-4 z-50 hidden">
        <div class="bg-white border-l-4 p-4 shadow-lg rounded-lg max-w-md"></div>
    </div>

    <div class="bg-white rounded-lg container-shadow p-8 mx-auto max-w-2xl">
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-800">
                <span class="text-orange-600">MAXIT</span> SA
            </h1>
        </div>

        <form class="space-y-6" action="/register" method="POST" enctype="multipart/form-data" id="registrationForm">
            <!-- CNI -->
            <div>
                <label class="block text-orange-600 font-semibold mb-2">
                    Numéro CNI <span class="text-orange-600">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        class="w-full pl-10 pr-4 py-3 border-2 border-orange-300 rounded-lg text-gray-700 input-focus transition-all duration-200"
                        name="numero_cni"
                        id="numero_cni"
                        maxlength="13"
                        placeholder="Entrez votre numéro CNI (13 chiffres)"
                    >
                </div>
            </div>

            <!-- Bouton de vérification CNI -->
            <div class="mt-4">
                <button type="button" 
                        id="checkCitizenBtn" 
                        class="w-full px-6 py-3 bg-orange-600 text-white font-semibold rounded-lg hover:bg-orange-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="bi bi-search"></i> Vérifier le citoyen
                </button>
            </div>

            <!-- Message de statut -->
            <div id="statusMessage" class="mt-3 text-center hidden">
                <!-- Le message de statut sera inséré ici -->
            </div>

            <!-- Champs masqués par défaut -->
            <div id="hiddenFields" class="hidden space-y-6">
                <!-- Nom et Prénom -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-orange-600 font-semibold mb-2">
                            Nom <span class="text-orange-600">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-person text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   name="nom" 
                                   id="nom" 
                                   readonly 
                                   class="w-full pl-10 pr-4 py-3 border-2 border-orange-300 rounded-lg bg-gray-100">
                        </div>
                    </div>
                    <div>
                        <label class="block text-orange-600 font-semibold mb-2">
                            Prénom <span class="text-orange-600">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-person text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   name="prenom" 
                                   id="prenom" 
                                   readonly 
                                   class="w-full pl-10 pr-4 py-3 border-2 border-orange-300 rounded-lg bg-gray-100">
                        </div>
                    </div>
                </div>

                <!-- Autres champs -->
                <div>
                    <label class="block text-orange-600 font-semibold mb-2">
                        Numéro Téléphone <span class="text-orange-600">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bi bi-telephone text-gray-400"></i>
                        </div>
                        <input type="tel" 
                               name="numero_telephone" 
                               required 
                               class="w-full pl-10 pr-4 py-3 border-2 border-orange-300 rounded-lg input-focus">
                    </div>
                </div>

                <!-- Mot de passe -->
                <div>
                    <label class="block text-orange-600 font-semibold mb-2">
                        Mot de passe <span class="text-orange-600">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bi bi-lock text-gray-400"></i>
                        </div>
                        <input type="password" 
                               name="password" 
                               required 
                               class="w-full pl-10 pr-4 py-3 border-2 border-orange-300 rounded-lg input-focus">
                    </div>
                </div>

                <!-- Photos CNI -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-orange-600 font-semibold mb-2">
                            Photo Recto CNI <span class="text-orange-600">*</span>
                        </label>
                        <input type="file" 
                               name="photorecto" 
                               required 
                               accept="image/*"
                               class="w-full px-3 py-2 border-2 border-orange-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-orange-600 font-semibold mb-2">
                            Photo Verso CNI <span class="text-orange-600">*</span>
                        </label>
                        <input type="file" 
                               name="photoverso" 
                               required 
                               accept="image/*"
                               class="w-full px-3 py-2 border-2 border-orange-300 rounded-lg">
                    </div>
                </div>

                <!-- Bouton de soumission -->
                <button type="submit" 
                        id="submitBtn" 
                        disabled 
                        class="w-full px-6 py-3 bg-orange-600 text-white font-semibold rounded-lg hover:bg-orange-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="bi bi-check-circle"></i> Créer mon compte
                </button>
            </div>
        </form>

        <!-- Section de debug -->
        <div class="mt-8 p-4 bg-gray-100 rounded-lg">
            <h3 class="font-bold text-gray-700 mb-2">Debug Console:</h3>
            <div id="debugConsole" class="text-sm text-gray-600 font-mono bg-white p-2 rounded max-h-40 overflow-y-auto"></div>
        </div>
    </div>

    <script>
        // Fonction de debug pour afficher les messages dans la console de debug
        function debugLog(message) {
            const debugConsole = document.getElementById('debugConsole');
            const timestamp = new Date().toLocaleTimeString();
            debugConsole.innerHTML += `[${timestamp}] ${message}<br>`;
            debugConsole.scrollTop = debugConsole.scrollHeight;
            console.log(message);
        }

        document.addEventListener('DOMContentLoaded', function() {
            debugLog('Script chargé et DOM prêt !');
            
            // Vérifiez que les éléments sont trouvés
            const elements = {
                cniInput: document.getElementById('numero_cni'),
                hiddenFields: document.getElementById('hiddenFields'),
                submitBtn: document.getElementById('submitBtn'),
                checkBtn: document.getElementById('checkCitizenBtn'),
                form: document.getElementById('registrationForm'),
                statusMessage: document.getElementById('statusMessage')
            };
            
            debugLog('Éléments trouvés: ' + JSON.stringify(Object.keys(elements).reduce((acc, key) => {
                acc[key] = elements[key] ? 'OK' : 'NOT FOUND';
                return acc;
            }, {})));
            
            const { cniInput, hiddenFields, submitBtn, checkBtn, form, statusMessage } = elements;
            
            // Fonction pour afficher les toasts
            function showToast(message, type = 'success') {
                debugLog(`Toast: ${type} - ${message}`);
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
                const isValid = /^\d{13}$/.test(cni);
                debugLog(`Validation CNI "${cni}": ${isValid ? 'VALIDE' : 'INVALIDE'}`);
                return isValid;
            }

            // Fonction pour simuler l'API (pour test)
            function simulateAPICall(cni) {
                debugLog(`Simulation API pour CNI: ${cni}`);
                return new Promise((resolve, reject) => {
                    setTimeout(() => {
                        // Simuler des données de test
                        if (cni === '1234567890123') {
                            resolve({
                                data: {
                                    nom: 'DIOP',
                                    prenom: 'Amadou'
                                }
                            });
                        } else {
                            reject(new Error('Citoyen non trouvé'));
                        }
                    }, 1000);
                });
            }

            // Gestionnaire du bouton de vérification
            if (checkBtn) {
                checkBtn.addEventListener('click', async function() {
                    debugLog('Bouton vérification cliqué !');
                    
                    const cni = cniInput.value.trim();
                    debugLog(`CNI saisi: "${cni}"`);
                    
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
                    debugLog('Début de la vérification...');

                    try {
                        // Utiliser la simulation d'API pour les tests
                        // Remplacez par votre vraie API en production
                        const useRealAPI = false; // Changez à true pour utiliser la vraie API
                        
                        debugLog(`Utilisation ${useRealAPI ? 'vraie API' : 'simulation API'}`);
                        
                        let data;
                        if (useRealAPI) {
                            const response = await fetch(`https://appdaf-0soa.onrender.com/citoyens/${cni}`);
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            data = await response.json();
                        } else {
                            data = await simulateAPICall(cni);
                        }

                        debugLog('Données reçues: ' + JSON.stringify(data));

                        // Vérifier la structure des données reçues
                        if (data && data.data && data.data.nom && data.data.prenom) {
                            // Obtenir les références des champs
                            const nomInput = document.getElementById('nom');
                            const prenomInput = document.getElementById('prenom');
                            
                            // Définir les valeurs
                            nomInput.value = data.data.nom;
                            prenomInput.value = data.data.prenom;
                            
                            debugLog(`Champs remplis: nom="${nomInput.value}", prenom="${prenomInput.value}"`);
                            
                            // S'assurer que les champs sont en lecture seule
                            nomInput.readOnly = true;
                            prenomInput.readOnly = true;
                            
                            // Afficher les champs cachés
                            hiddenFields.classList.remove('hidden');
                            submitBtn.disabled = false;
                            
                            showToast('Citoyen trouvé');
                            statusMessage.innerHTML = '<div class="text-green-600"><i class="bi bi-check-circle"></i> Citoyen vérifié avec succès</div>';
                            statusMessage.classList.remove('hidden');
                            
                            debugLog('Vérification réussie !');
                        } else {
                            throw new Error('Format de données invalide');
                        }
                    } catch (error) {
                        debugLog('Erreur: ' + error.message);
                        showToast('Aucun citoyen trouvé avec ce numéro de CNI', 'error');
                        statusMessage.innerHTML = '<div class="text-red-600"><i class="bi bi-x-circle"></i> Aucun citoyen trouvé</div>';
                        statusMessage.classList.remove('hidden');
                    } finally {
                        // Réactiver le bouton
                        checkBtn.disabled = false;
                        checkBtn.innerHTML = '<i class="bi bi-search"></i> Vérifier le citoyen';
                        debugLog('Bouton réactivé');
                    }
                });
                
                debugLog('Event listener ajouté au bouton de vérification');
            } else {
                debugLog('ERREUR: Bouton de vérification non trouvé !');
            }

            // Validation du formulaire
            if (form) {
                form.addEventListener('submit', function(e) {
                    debugLog('Soumission du formulaire');
                    const cni = cniInput.value.trim();
                    if (!isValidCNI(cni)) {
                        e.preventDefault();
                        showToast('Numéro CNI invalide', 'error');
                        debugLog('Soumission bloquée: CNI invalide');
                    }
                });
                debugLog('Event listener ajouté au formulaire');
            } else {
                debugLog('ERREUR: Formulaire non trouvé !');
            }

            // Ajout d'un listener sur le champ CNI pour feedback en temps réel
            if (cniInput) {
                cniInput.addEventListener('input', function() {
                    const cni = this.value.trim();
                    debugLog(`CNI modifié: "${cni}"`);
                    
                    if (cni.length === 13) {
                        if (isValidCNI(cni)) {
                            this.style.borderColor = '#16a34a'; // Vert
                        } else {
                            this.style.borderColor = '#dc2626'; // Rouge
                        }
                    } else {
                        this.style.borderColor = '#fb923c'; // Orange par défaut
                    }
                });
                debugLog('Event listener ajouté au champ CNI');
            }

            debugLog('=== Initialisation terminée ===');
        });
    </script>
</body>
</html>
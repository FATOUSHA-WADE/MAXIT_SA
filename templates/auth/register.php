<?php
$errors = $this->session->unset('errors') ?? [];
$success = $this->session->unset('success') ?? '';
?>

<!-- Toast container -->
<div id="toast" class="fixed top-4 right-4 z-50 hidden">
<div class="bg-white border-l-4 p-4 shadow-lg rounded-lg max-w-md"></div>
</div>

<div class="bg-white rounded-lg container-shadow p-8 mx-auto">
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
>
</div>
</div>

<!-- Bouton de vérification CNI -->
<div class="mt-4">
<button type="button" 
id="checkCitizenBtn" 
class="w-full px-6 py-3 bg-orange-600 text-white font-semibold rounded-lg hover:bg-orange-700 transition-colors">
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
<input type="text" name="nom" id="nom" readonly class="w-full pl-10 pr-4 py-3 wborder-2 border-orange-300 rounded-lg bg-gray-100">
</div>
</div>
<div>
<label class="block text-orange-600 font-semibold mb-2">
Prénom <span class="text-orange-600">*</span>
</label>
<div class="relative">
<input type="text" name="prenom" id="prenom" readonly class="w-full pl-10 pr-4 py-3 border-2 border-orange-300 rounded-lg bg-gray-100">
</div>
</div>
</div>

<!-- Autres champs -->
<div>
<label class="block text-orange-600 font-semibold mb-2">
Numéro Téléphone <span class="text-orange-600">*</span>
</label>
<div class="relative">
<input type="tel" name="numero_telephone" required class="w-full pl-10 pr-4 py-3 border-2 border-orange-300 rounded-lg">
</div>
</div>

<!-- Mot de passe -->
<div>
<label class="block text-orange-600 font-semibold mb-2">
Mot de passe <span class="text-orange-600">*</span>
</label>
<div class="relative">
<input type="password" name="password" required class="w-full pl-10 pr-4 py-3 border-2 border-orange-300 rounded-lg">
</div>
</div>

<!-- Photos CNI -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div>
<label class="block text-orange-600 font-semibold mb-2">
Photo Recto CNI <span class="text-orange-600">*</span>
</label>
<input type="file" name="photorecto" required class="w-full">
</div>
<div>
<label class="block text-orange-600 font-semibold mb-2">
Photo Verso CNI <span class="text-orange-600">*</span>
</label>
<input type="file" name="photoverso" required class="w-full">
</div>
</div>

<!-- Bouton de soumission -->
<button type="submit" id="submitBtn" disabled class="w-full px-6 py-3 bg-orange-600 text-white font-semibold rounded-lg disabled:opacity-50 disabled:cursor-not-allowed">
Créer mon compte
</button>
</div>
</form>
</div>

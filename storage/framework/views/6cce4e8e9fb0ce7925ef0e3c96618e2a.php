    <?php $__env->startSection('contenu1'); ?>
    <div id="contenu">

        <?php $__currentLoopData = $liste; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unliste): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<form action="<?php echo e(Route('modificauser')); ?>" method="post">
    <?php echo csrf_field(); ?>
    <input type="hidden" id="mdp" name="mdp" value="<?php echo e($unliste['mdp']); ?>">
    <input type="hidden" id="id" name="id" value="<?php echo e($unliste['id']); ?>">
  
    <br>
    <br>

  <label for="lname">Nom:</label><br>
  <input type="text" id="nom" name="nom" value="<?php echo e($unliste['nom']); ?>">

  <br>

  <br>

  <label for="fname">Login:</label><br>
  <input type="text" id="login" name="login" value="<?php echo e($unliste['login']); ?>">

  <br>

  <br>

  <label for="fname">Prénom:</label><br>
  <input type="text" id="prenom" name="prenom" value="<?php echo e($unliste['prenom']); ?>">

  <br>
  <br>

  <label for="fname">Adresse:</label><br>
  <input type="text" id="adresse" name="adresse" value="<?php echo e($unliste['adresse']); ?>">

  <br>
  <br>

  <label for="fname">Code Postal:</label><br>
  <input type="text" id="cp" name="cp" value="<?php echo e($unliste['cp']); ?>">

  <br>
  <br>

  <label for="fname">Ville:</label><br>
  <input type="text" id="ville" name="ville" value="<?php echo e($unliste['ville']); ?>">

  <br>
  <label for="fname">Date:</label><br>
  <input type="text" placeholder="yyyy-mm-dd" id="text" name="date" value="<?php echo e($unliste['dateEmbauche']); ?>">

  <br>
  <br>
  <input type="submit" id="btn" value="Valider">




</form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('sommaire', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\gsblaravel_final\resources\views/formmodif.blade.php ENDPATH**/ ?>
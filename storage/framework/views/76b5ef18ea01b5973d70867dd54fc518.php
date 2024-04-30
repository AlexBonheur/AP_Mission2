<?php $__env->startSection('contenu1'); ?>
<div id="contenu">
<form action="<?php echo e(Route('ajoutuser')); ?>" method="post">
    <?php echo e(csrf_field()); ?>

    <br>
    <label for="fname">Prénom:</label><br>
    <input type="text" id="prenom" name="prenom" >

  <br>
    <label for="lname">Nom:</label><br>
    <input type="text" id="nom" name="nom">

  <br>

  <br>

  <label for="fname">Login:</label><br>
  <input type="text" id="login" name="login">

  <br>

  <br>
    <label for="lname">Mdp:</label><br>
    <input type="text" id="mdp" name="mdp">
  
    <br>

  <br>

  
  <br>

  <label for="fname">Adresse:</label><br>
  <input type="text" id="adresse" name="adresse">

  <br>
  <br>

  <label for="fname">Code Postal:</label><br>
  <input type="text" id="cp" name="cp" value=>

  <br>
  <br>

  <label for="fname">Ville:</label><br>
  <input type="text" id="ville" name="ville">

  <br>
  <label for="fname">Date:</label><br>
  <input type="text" placeholder="yyyy-mm-dd" id="text" name="date">

  <br>
  <br>
  <input type="submit" id="btn" value="Valider">




</form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('sommaire', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\gsblaravel_final\resources\views/form_ajout.blade.php ENDPATH**/ ?>
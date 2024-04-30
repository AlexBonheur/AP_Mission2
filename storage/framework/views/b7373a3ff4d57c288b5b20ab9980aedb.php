    <?php $__env->startSection('contenu1'); ?>
        <div class="container text-center contenu" id="contenu">
            <div class=" corpsForm row">
                <div class="col">
                    <h1>liste des visiteurs</h1>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Nom</th>
                                <th>Prenom</th>
                                <th>Login</th>
                                <th>Mdp</th>
                                <th>Adresse</th>
                                <th>Code Postal</th>
                                <th>Ville</th>
                                <th>Date d'embauche</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $liste; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unliste): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($unliste['id']); ?></td>
                                <td><?php echo e($unliste['nom']); ?></td>
                                <td><?php echo e($unliste['prenom']); ?></td>
                                <td><?php echo e($unliste['login']); ?></td>
                                <td><?php echo e($unliste['mdp']); ?></td>
                                <td><?php echo e($unliste['adresse']); ?></td>
                                <td><?php echo e($unliste['cp']); ?></td>
                                <td><?php echo e($unliste['ville']); ?></td>
                                <td><?php echo e($unliste['dateEmbauche']); ?></td>
                                
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        </table><hr>
                        <a href="<?php echo e(Route('pdf_test', ['id'=>$unliste['id']])); ?>">Générer le pdf</a>
                </div> 
            </div>       
        </div>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('sommaire', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\gsblaravel_final\resources\views/etatvisiteur.blade.php ENDPATH**/ ?>
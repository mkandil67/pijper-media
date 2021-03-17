<?php $__env->startSection('content'); ?>
    <div class="container-fluid pt-3">
        <div class="row">

            <div class="col-md-3">
                <div class="card">
                    <div class="card-header"><?php echo e(__('Selected Categories')); ?></div>
                    <form action="/categories" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="card-body">
                            <div class="form-group row"></div>

                            <input type="checkbox" name="categories[]" value="News" <?php echo e(($categories['News']) ? 'checked' : ''); ?> > News<br/>
                            <input type="checkbox" name="categories[]" value="Showbizz/Entertainment" <?php echo e(($categories['Showbizz/Entertainment']) ? 'checked' : ''); ?> > Showbizz/Entertainment<br/>
                            <input type="checkbox" name="categories[]"  value="Royals" <?php echo e(($categories['Royals']) ? 'checked' : ''); ?> > Royals<br/>
                            <input type="checkbox" name="categories[]"  value="Food/Recipes" <?php echo e(($categories['Food/Recipes']) ? 'checked' : ''); ?> > Food/Recipes<br/>
                            <input type="checkbox" name="categories[]"  value="Lifehacks" <?php echo e(($categories['Lifehacks']) ? 'checked' : ''); ?> > Lifehacks<br/>
                            <input type="checkbox" name="categories[]"  value="Fashion" <?php echo e(($categories['Fashion']) ? 'checked' : ''); ?> > Fashion<br/>
                            <input type="checkbox" name="categories[]"  value="Beauty" <?php echo e(($categories['Beauty']) ? 'checked' : ''); ?> > Beauty<br/>
                            <input type="checkbox" name="categories[]"  value="Health" <?php echo e(($categories['Health']) ? 'checked' : ''); ?> > Health<br/>
                            <input type="checkbox" name="categories[]"  value="Family" <?php echo e(($categories['Family']) ? 'checked' : ''); ?> > Family<br/>
                            <input type="checkbox" name="categories[]"  value="House and garden" <?php echo e(($categories['House and garden']) ? 'checked' : ''); ?> > House and Garden<br/>
                            <input type="checkbox" name="categories[]"  value="Cleaning" <?php echo e(($categories['Cleaning']) ? 'checked' : ''); ?> > Cleaning<br/>
                            <input type="checkbox" name="categories[]"  value=" Lifestyle" <?php echo e(($categories['Lifestyle']) ? 'checked' : ''); ?> > Lifestyle<br/>
                            <input type="checkbox" name="categories[]" value="Lifestyle" <?php echo e(($categories['Lifestyle']) ? 'checked' : ''); ?> > Cars<br/>
                            <input type="checkbox" name="categories[]"  value="Crime" <?php echo e(($categories['Crime']) ? 'checked' : ''); ?> > Crime<br/>


                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-5">
                                    <button type="submit" class="btn btn-primary">
                                        <?php echo e(__('Submit')); ?>

                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md">

                <div class="card mb-3">
                    <div class="card-header"><?php echo e(__('New articles')); ?></div>

                    <div class="card-body">


                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><?php echo e(__('Posts')); ?></div>

                    <div class="card-body">



                    </div>
                </div>



            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mkandil67/Documents/Block 1C/Software Engineering/pijper-media/social-wall-app/resources/views/home.blade.php ENDPATH**/ ?>
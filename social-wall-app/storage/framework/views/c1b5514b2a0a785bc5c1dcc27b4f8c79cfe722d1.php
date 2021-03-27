<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    body {
        font-family: sans-serif;
    }

    .container {
        width: 90%;
        margin: 50px auto;
    }
    .heading {
        text-align: center;
        font-size: 30px;
        margin-bottom: 50px;
    }

    .container-fluid .btn {
        width: 100px;
    }

    .row {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        flex-flow: row;
    }

    .card {
        background: #fff;
        border: 1px solid #ccc;
        margin-bottom: 50px;
        transition: 0.3s;
    }

    .card-header {
        text-align: center;
        padding: 50px 10px;
        color: #fff;
    }

    .card-body {
        padding: 30px 20px;
        text-align: center;
        font-size: 18px;
    }

    .card-body .btn {
        display: block;
        color: #fff;
        background: #363795;
        text-align: center;
        margin-top: 30px;
        text-decoration: none;
        padding: 10px 5px;
    }

    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 0 40px -10px rgba(0, 0, 0, 0.25);
    }

    @media  screen and (max-width: 1000px) {
        .card {
            width: 40%;
        }
    }

    @media  screen {
        .container {
            width: 100%;
        }

        .heading {
            padding: 20px;
            font-size: 20px;
        }

        .card {
            width: 80%;
        }
    }
</style>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid pt-3">
        <div class="col-md">
            <div id="accordion">
                <div style="background: #F2F2F2;" class="container-fluid border mb-lg-5">
                    <div class="card-header">
                        <a href="#collapseCard" data-toggle="collapse" class="collapsed">
                            Recent Activity
                            <span class="text-danger readLess">(show less)</span>
                            <span class="text-info readMore">(show more)</span>
                        </a></div>
                    <div id="collapseCard" class="collapse " data-parent="#accordion">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 row-cols-lg-6 pt-5">
                            <?php $__currentLoopData = App\Models\Post::where('writer_id','>',0)->where('updated_at', '>=', \Carbon\Carbon::now()->subHour())->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="card shadow-sm m-1 mb-5 ">
                                    <?php if(strtolower($post->platform) == 'facebook'): ?>
                                        <div class="d-inline pt-1">
                                            <svg role="img" xmlns="http://www.w3.org/2000/svg" style="margin: 5px" width="32px" height="32px" viewBox="0 0 24 24"><title>Facebook icon</title><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                            <span class = "pl-2 font-weight-bold primary"><?php echo e($post->data_source); ?></span>
                                        </div>
                                    <?php elseif(strtyolower($post->platform) == 'instagram'): ?>
                                        <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="margin: 5px" width="32px" height="32px"><title>Instagram icon</title><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>
                                    <?php elseif(strtolower($post->platform) == 'twitter'): ?>)
                                    <svg role="img" xmlns="http://www.w3.org/2000/svg" style="margin: 5px" width="32px" height="32px" viewBox="0 0 24 24"><title>Twitter icon</title><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                                    <?php endif; ?>
                                    <span style="text-align: center">Written by <?php echo e(($post->writer_id == $user->id) ? 'you' : $user->name); ?></span>
                                    <div class="card-body">
                                        <div style="border: #acacac 0.0004cm solid; border-radius: 15px" class="card-body mb-2 h-50 d-flex justify-content-center">
                                            <small class="card-text font-weight-bold"><?php echo e(Str::limit($post->caption, $limit = 120, $end = '...')); ?></small>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <small class="text-danger font-weight-bold">Engagement: <?php echo e($post->engagement); ?></small>
                                            <small class="text-muted"><?php echo e($post->category); ?></small>
                                        </div>
                                        <div class="row">
                                            <form style="display: inline-flex;" action="<?php echo e(route('posts', ['id' => $post->id, 'user' => $user->id])); ?>" method="POST" id="form">
                                                <a href="<?php echo e($post->post_url); ?>" type="button" class="btn btn-sm btn-outline-primary font-weight-bold">Source</a>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center pb-4">
                                        <small class="text-muted">Added <?php echo e($post->updated_at->diffForHumans()); ?></small>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>

            <ul class="nav nav-tabs nav-fill mb-3 nav-justified" id="myTab" role="tablist">
                <li class="border-b nav-item waves-effect waves-light">
                    <a class="nav-link active" id="facebook-tab" data-toggle="tab" href="#facebook" role="tab" aria-controls="facebook" aria-selected="true"><img class="mr-1" src="/pics/facebook.svg" width="16px" height="16px"> facebook</a>
                </li>
                <li class="border-b nav-item waves-effect waves-light">
                    <a class="nav-link" id="instagram-tab" data-toggle="tab" href="#instagram" role="tab" aria-controls="instagram" aria-selected="false"><img class="mr-1" src="/pics/instagram.svg" width="16px" height="16px"> instagram</a>
                </li>
                <li class="border-b nav-item waves-effect waves-light">
                    <a class="nav-link" id="twitter-tab" data-toggle="tab" href="#twitter" role="tab" aria-controls="twitter" aria-selected="false"><img class="mr-1" src="/pics/twitter.svg" width="16px" height="16px"> twitter</a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show" id="facebook" role="tabpanel" aria-labelledby="facebook-tab">
                    <div class="container-fluid" id="postsCard">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 row-cols-lg-6">
                            <?php $__currentLoopData = App\Models\Post::where('writer_id','=',null)->orderBy('posted_at','desc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($categories[$post->category]): ?>
                                    <div class="card shadow-sm m-1 mb-5 ">

                                        <?php if(strtolower($post->platform) == 'facebook'): ?>
                                            <div class="d-inline pt-1">
                                                <svg role="img" xmlns="http://www.w3.org/2000/svg" style="margin: 5px" width="32px" height="32px" viewBox="0 0 24 24"><title>Facebook icon</title><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                                <span class = "pl-2 font-weight-bold primary"><?php echo e($post->data_source); ?></span>
                                            </div>
                                        <?php elseif(strtolower($post->platform) == 'instagram'): ?>
                                            <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="margin: 5px" width="32px" height="32px"><title>Instagram icon</title><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>
                                        <?php elseif(strtolower($post->platform) == 'twitter'): ?>)
                                        <svg role="img" xmlns="http://www.w3.org/2000/svg" style="margin: 5px" width="32px" height="32px" viewBox="0 0 24 24"><title>Twitter icon</title><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                                        <?php endif; ?>

                                        <div class="card-body">
                                            <div style="border: #acacac 0.0004cm solid; border-radius: 15px" class="card-body mb-2 h-50 d-flex justify-content-center">
                                                <small class="card-text font-weight-bold"><?php echo e(Str::limit($post->caption, $limit = 120, $end = '...')); ?></small>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <small class="text-danger font-weight-bold">Engagement: <?php echo e($post->engagement); ?></small>
                                                <small class="text-muted"><?php echo e($post->category); ?></small>
                                            </div>
                                            <div class="row">
                                                <form style="display: inline-flex;" action="<?php echo e(route('posts', ['id' => $post->id, 'user' => $user->id])); ?>" method="POST" id="form">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="id" value="<?php echo e($post->id); ?>">
                                                    <button style="margin-right: 10px" type="submit" class="btn btn-sm btn-outline-primary font-weight-bold">Add</button>
                                                    <a href="<?php echo e($post->post_url); ?>" type="button" class="btn btn-sm btn-outline-primary font-weight-bold">Source</a>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center pb-4">
                                            <small class="text-muted">Posted <?php echo e(Carbon\Carbon::parse($post->posted_at)->diffForHumans()); ?></small>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                     </div>
                </div>

                <div class="tab-pane fade" id="instagram" role="tabpanel" aria-labelledby="instagram-tab">
                    INSTA
                </div>

                <div class="tab-pane fade" id="twitter" role="tabpanel" aria-labelledby="twitter-tab">
                    TWITTER
                </div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mkandil67/Documents/Block 1C/Software Engineering/pijper-media/social-wall-app/resources/views/home.blade.php ENDPATH**/ ?>
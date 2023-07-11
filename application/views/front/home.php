    <?php $this->load->view('front/header'); ?>

    <div id="carouselExampleControls" class="carousel slide carousel-fade" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="<?php echo base_url('public/images/slide1.jpg'); ?>" class="d-block w-100" alt="">
          </div>
          <div class="carousel-item">
            <img src="<?php echo base_url('public/images/slide2.jpg'); ?>" class="d-block w-100" alt="">
          </div>
          <div class="carousel-item">
            <img src="<?php echo base_url('public/images/slide3.jpg'); ?>" class="d-block w-100" alt="">
          </div>
        </div>
       <button class="carousel-control-prev" type="button" data-target="#carouselExampleControls" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-target="#carouselExampleControls" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </button>
      </div>

      <div class="container pt-4 pb-4">
        <h3 class="pb-3">About Company</h3>
            <p class="text-muted">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis consequuntur a obcaecati consectetur, voluptates id! Quasi repellat accusantium alias dolore quod nesciunt. Obcaecati saepe esse nobis ipsam cupiditate? Voluptatibus temporibus reprehenderit architecto quisquam, repudiandae ducimus similique a illum minus laboriosam magnam at labore debitis commodi voluptatem quasi, suscipit neque incidunt nemo voluptatum. Accusantium quisquam praesentium ab soluta nostrum dolorum cum! Atque, delectus, ex molestias quam accusantium quo cumque eaque recusandae quae tempora in officiis, ipsum facilis minus sint at labore nobis exercitationem? Ex delectus, officia nisi amet, voluptatem voluptates harum veniam iure molestias debitis, ipsam accusamus sunt consectetur recusandae asperiores.
            </p>

            <p class="text-muted">
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quibusdam, sunt officiis necessitatibus voluptatibus atque quo! Dolore eos quos facere perferendis explicabo, ratione expedita quisquam consectetur et quasi, nisi id inventore, odit omnis unde accusantium nam dignissimos impedit fuga quod doloribus libero! Necessitatibus ad suscipit deleniti consequatur. Hic illum vitae similique eum eveniet nisi nemo necessitatibus possimus accusamus voluptatibus, tenetur fuga corporis ea, delectus porro cumque mollitia, veritatis dignissimos iure distinctio doloribus excepturi deleniti? Magni, suscipit. Facere saepe itaque deserunt recusandae unde animi qui atque at nemo maiores repellat nostrum perspiciatis aperiam officia commodi mollitia asperiores, enim eos possimus eveniet blanditiis!
            </p>
      </div>

      <div class="bg-light pb-4">
        <div class="container">
            <h3 class="pb-3 pt-4">OUR SERVICES</h3>
            <div class="row">
                <div class="col-md-3">
                    <div class="card h-100">
                        <img src="<?php echo base_url('public/images/box1.jpg') ?>" class="card-img-top" alt="">
                        <div class="card-body">
                          <h5 class="card-title">Website Development</h5>
                          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                      </div>
                </div>

                <div class="col-md-3">
                    <div class="card h-100">
                        <img src="<?php echo base_url('public/images/box2.jpg') ?>" class="card-img-top" alt="">
                        <div class="card-body">
                          <h5 class="card-title">Digital Marketing</h5>
                          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                      </div>
                </div>

                <div class="col-md-3">
                    <div class="card h-100">
                        <img src="<?php echo base_url('public/images/box3.jpg') ?>" class="card-img-top" alt="">
                        <div class="card-body">
                          <h5 class="card-title">Mobile App Development</h5>
                          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                      </div>
                </div>

                <div class="col-md-3">
                    <div class="card h-100">
                        <img src="<?php echo base_url('public/images/box4.jpg') ?>" class="card-img-top" alt="">
                        <div class="card-body">
                          <h5 class="card-title">IT Consulting Services</h5>
                          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                      </div>
                </div>
            </div>
        </div>
      </div>

    <?php if(!empty($articles)) { ?>

      <div class="pb-4 pt-4">
        <div class="container">
            <h3 class="pb-3 pt-4">LATEST BLOGS</h3>
            <div class="row">

                <?php foreach($articles as $article) { ?>

                <div class="col-md-3">
                    <div class="card h-100">
                        <a href="<?php echo base_url('blog/detail/'.$article['id']);?>">
                          <?php if(file_exists('./public/uploads/articles/'.$article['image'])) { ?>
                                <img src="<?php echo base_url('public/uploads/articles/'.$article['image']) ?>" class="card-img-top" alt="">
                          <?php } ?>
                        </a>
                       
                        <div class="card-body">
                          <p class="card-text"><?php echo $article['title']; ?></p>
                          <a class="btn btn-primary btn-sm" href="<?php echo base_url('blog/detail/'.$article['id']);?>">Read More</a>
                        </div>
                      </div>
                </div>

                <?php } ?>

                <!-- <div class="col-md-3">
                    <div class="card h-100">
                        <img src="<?php echo base_url('public/images/box2.jpg') ?>" class="card-img-top" alt="">
                        <div class="card-body">
                          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                      </div>
                </div>

                <div class="col-md-3">
                    <div class="card h-100">
                        <img src="<?php echo base_url('public/images/box3.jpg') ?>" class="card-img-top" alt="">
                        <div class="card-body">
                          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                      </div>
                </div>

                <div class="col-md-3">
                    <div class="card h-100">
                        <img src="<?php echo base_url('public/images/box4.jpg') ?>" class="card-img-top" alt="">
                        <div class="card-body">
                          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                      </div>
                </div> -->
            </div>
        </div>
      </div>

    <?php } ?>

      <?php $this->load->view('front/footer'); ?>
      
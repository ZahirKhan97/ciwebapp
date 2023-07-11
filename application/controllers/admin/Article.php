<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $admin = $this->session->userdata('admin');

        if(empty($admin))
        {
            $this->session->set_flashdata('msg', 'Your session has been expired !');
            redirect(base_url().'admin/login/index');
        }
    }

    // this method will show article listing 
	public function index($page=1)
	{
        $per_page = 5;
        $param['offset'] = $per_page;
        $param['limit'] = ($page * $per_page)-$per_page;
        $param['q'] = $this->input->get('q');
        
        $this->load->model("Article_model");
        $this->load->library('pagination');
        $config['base_url'] = base_url('admin/article/index');
        $config['total_rows'] = $this->Article_model->getArticlesCount($param);
        $config['use_page_numbers'] = true;
        $config['per_page'] = $per_page;
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = "<li class = 'page-item'>";
        $config['num_tag_close'] = "</li>";
        $config['cur_tag_open'] = "<li class = 'page-item disabled'><li class='active page-item'><a href='#' class='page-link'>";
        $config['cur_tag_close'] = "<span class='sr-only'</span></a></li>";
        $config['next_tag_open'] = "<li class = 'page-item'>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li class = 'page-item' >";
        $config['prev_tag_close'] = "</li>";
        $config['first_tagl_open'] = "<li class = 'page-item' >";
        $config['first_tag_close'] = "</li>";
        $config['last_tag_open'] = "<li class = 'page-item' >";
        $config['last_tag_close'] = "</li>";
        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);
        $pagination_links = $this->pagination->create_links();

        $articles = $this->Article_model->getArticles($param);

        $data['q'] = $this->input->get('q');
       // print_r($articles);
        $data['articles'] = $articles;
        $data['pagination_links'] = $pagination_links;
        $data['mainModule'] = 'article';
        $data['subModule'] = 'viewArticle';

       
        $this->load->view("admin/article/list", $data);
	}

    // this method will create article
    public function create()
	{
        $this->load->model("Category_model");
        $this->load->model("Article_model");
        $this->load->helper('common_helper');

        $data['mainModule'] = 'article';
        $data['subModule'] = 'createArticle';

        $categories = $this->Category_model->getCategories();
        $data['categories'] = $categories;

        // file upload settings
        $config['upload_path'] = './public/uploads/articles';
        $config['allowed_types'] = 'gif|png|jpg|jpeg';
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);


        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="invalid-feedback">', '</p>');
        $this->form_validation->set_rules('category_id', 'Category', 'trim|required');
        $this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[20]');
        $this->form_validation->set_rules('author', 'Author', 'trim|required');

        if($this->form_validation->run() == true){
            // form validated successfully and we can proceed
            if(!empty($_FILES['image']['name'])) {

                // Here we will save images
                if($this->upload->do_upload('image')){

                    $data = $this->upload->data();
                    
                    resizeImage($config['upload_path'].$data['file_name'],$config['upload_path'].'thumb_front/'.$data['file_name'],1120,800); 
                    resizeImage($config['upload_path'].$data['file_name'],$config['upload_path'].'thumb_admin/'.$data['file_name'],300,250); 


                    $formArray['image'] = $data['file_name'];
                    $formArray['title'] = $this->input->post('title');
                    $formArray['category'] = $this->input->post('category_id');
                    $formArray['description'] = $this->input->post('description');
                    $formArray['author'] = $this->input->post('author');
                    $formArray['status'] = $this->input->post('status');
                    $formArray['created_at'] = date('Y-m-d H:i:s');
                    $this->Article_model->addArticle($formArray);
                    $this->session->set_flashdata('success', 'Article added successfully');
                    redirect(base_url().'admin/article/index');
                }

                else {
                    // Image selected has some error
                    $errors = $this->upload->display_errors('<p class = "invalid-feedback">', '</p>');
                    $data['imageError'] = $errors;
                    $this->load->view("admin/article/create", $data);
                }

            } else {
                // Here we will add article without image

                $formArray['title'] = $this->input->post('title');
                $formArray['category'] = $this->input->post('category_id');
                $formArray['description'] = $this->input->post('description');
                $formArray['author'] = $this->input->post('author');
                $formArray['status'] = $this->input->post('status');
                $formArray['created_at'] = date('Y-m-d H:i:s');
                $this->Article_model->addArticle($formArray);
                $this->session->set_flashdata('success', 'Article added successfully');
                redirect(base_url().'admin/article/index');
            }

        } else {
            // for not validated, you can show errors

            $this->load->view("admin/article/create", $data);
        }

        
	}

    // this method will edit an article
    public function edit($id)
	{
        $this->load->library('form_validation');
        $this->load->model('Article_model');
        $this->load->model('Category_model');
        $this->load->helper('common_helper');

        $data['mainModule'] = 'article';
        $data['subModule'] = '';

        $article = $this->Article_model->getArticle($id);
       if (empty($article))
       {
        $this->session->set_flashdata('error', 'Article Not Found');
        redirect(base_url('admin/article/index'));
       }
        $categories = $this->Category_model->getCategories();
        $data['categories'] = $categories;
        $data['article'] = $article;

         // file upload settings
        $config['upload_path'] = './public/uploads/articles';
        $config['allowed_types'] = 'gif|png|jpg|jpeg';
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);


        $this->form_validation->set_error_delimiters('<p class="invalid-feedback">', '</p>');
        $this->form_validation->set_rules('category_id', 'Category', 'trim|required');
        $this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[20]');
        $this->form_validation->set_rules('author', 'Author', 'trim|required');

        if($this->form_validation->run() == true){
            // form validated successfully and we can proceed
            if(!empty($_FILES['image']['name'])) {

                // Here we will save images
                if($this->upload->do_upload('image')){

                    $data = $this->upload->data();

                    $path = './public/uploads/articles/'.$article['image'];
                    if ($article['image'] !="" && file_exists($path)) {
                        unlink($path); // this method will remove old image
                    }

                    $path = './public/uploads/articles/thumb_admin/'.$article['image'];
                    if ($article['image'] !="" && file_exists($path)) {
                        unlink($path); // this method will remove old image from thumb_admin folder
                    }

                    $path = './public/uploads/articles/thumb_front/'.$article['image'];
                    if ($article['image'] !="" && file_exists($path)) {
                        unlink($path); // this method will remove old image from thumb_front folder
                    }
                    
                    resizeImage($config['upload_path'].$data['file_name'],$config['upload_path'].'thumb_front/'.$data['file_name'],1120,800); 
                    resizeImage($config['upload_path'].$data['file_name'],$config['upload_path'].'thumb_admin/'.$data['file_name'],300,250); 


                    $formArray['image'] = $data['file_name'];
                    $formArray['title'] = $this->input->post('title');
                    $formArray['category'] = $this->input->post('category_id');
                    $formArray['description'] = $this->input->post('description');
                    $formArray['author'] = $this->input->post('author');
                    $formArray['status'] = $this->input->post('status');
                    $formArray['updated_at'] = date('Y-m-d H:i:s');
                    $this->Article_model->updateArticle($id,$formArray);
                    $this->session->set_flashdata('success', 'Article updated successfully');
                    redirect(base_url().'admin/article/index');
                }

                else {
                    // Image selected has some error
                    $errors = $this->upload->display_errors('<p class = "invalid-feedback">', '</p>');
                    $data['imageError'] = $errors;
                    $this->load->view('admin/article/edit', $data);
                }

            } else {
                // Here we will add article without image

                $formArray['title'] = $this->input->post('title');
                $formArray['category'] = $this->input->post('category_id');
                $formArray['description'] = $this->input->post('description');
                $formArray['author'] = $this->input->post('author');
                $formArray['status'] = $this->input->post('status');
                $formArray['updated_at'] = date('Y-m-d H:i:s');
                $this->Article_model->updateArticle($id,$formArray);
                $this->session->set_flashdata('success', 'Article updated successfully');
                redirect(base_url().'admin/article/index');
            }

        } else {
            // for not validated, you can show errors

            $this->load->view('admin/article/edit', $data);
        }

       
	}

    // this method will delete article
    public function delete($id)
	{
        $this->load->model('Article_model');
        $article = $this->Article_model->getArticle($id);
        if (empty($article))
        {
         $this->session->set_flashdata('error', 'Article Not Found');
         redirect(base_url('admin/article/index'));
        }

        $path = './public/uploads/articles/'.$article['image'];
                    if ($article['image'] !="" && file_exists($path)) {
                        unlink($path); // this method will remove old image
                    }

                    $path = './public/uploads/articles/thumb_admin/'.$article['image'];
                    if ($article['image'] !="" && file_exists($path)) {
                        unlink($path); // this method will remove old image from thumb_admin folder
                    }

                    $path = './public/uploads/articles/thumb_front/'.$article['image'];
                    if ($article['image'] !="" && file_exists($path)) {
                        unlink($path); // this method will remove old image from thumb_front folder
                    }

        $this->Article_model->deleteArticle($id);   // this will delete article
        $this->session->set_flashdata('success', 'Article has been deleted successfully');
        redirect(base_url().'admin/article/index');
	}
}
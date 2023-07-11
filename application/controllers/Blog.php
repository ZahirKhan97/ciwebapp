<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {
    // This method will show blog page
	public function index($page=1)
	{
        $this->load->model('Article_model');
        $this->load->helper('text');
        $this->load->library('pagination');

        $per_page = 5;
        $param['offset'] = $per_page;
        $param['limit'] = ($page * $per_page)-$per_page;

        $config['base_url'] = base_url('blog/index');
        $config['total_rows'] = $this->Article_model->getArticlesCount();
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
        $articles = $this->Article_model->getArticlesFront($param);

        $data = [];
        $data['articles'] = $articles;
        $data['pagination_links'] = $pagination_links;
       $this->load->view('front/blog', $data);
	}

    public function categories()
    {
        $this->load->model('Category_model');
        $categories = $this->Category_model->getCategoriesFront();
        $data = [];
        $data['categories'] = $categories;
        $this->load->view('front/categories', $data);
    }

    public function detail($id)
    {
        $this->load->model('Article_model');
        $this->load->model('Comment_model');
        $this->load->library('form_validation');
        $article = $this->Article_model->getArticle($id);
        if(empty($article))
        {
            redirect(base_url('blog/index'));
        }
        $data = [];
        $data['article'] = $article;

        $comments = $this->Comment_model->getComments($id,true);
        $data['comments'] = $comments;

        $this->form_validation->set_rules('name', 'Name', 'required|min_length[5]');
        $this->form_validation->set_rules('comment', 'Comment', 'required|min_length[10]');
        $this->form_validation->set_error_delimiters('<p class="mb-0">', '</p>');

        if ($this->form_validation->run()==true)
        {
            $formArray = [];
            $formArray['name'] = $this->input->post('name');
            $formArray['comment'] = $this->input->post('comment');
            $formArray['article_id'] = $id;
            $formArray['created_at'] = date('Y-m-d H:i:s');
            $this->Comment_model->create($formArray);
            
            $this->session->set_flashdata('message', 'Your Comment has been posted successfully');
            redirect(base_url('blog/detail/'.$id));
        }
        else
        {
            $this->load->view('front/detail', $data);
        }

    }

    public function category($category_id,$page=1)
    {
        $this->load->model('Article_model');
        $this->load->model('Category_model');
        $this->load->helper('text');
        $this->load->library('pagination');

        $category = $this->Category_model->getCategory($category_id);
        if (empty($category))
        {
            redirect(base_url('blog'));
        }

        $per_page = 5;
        $param['offset'] = $per_page;
        $param['limit'] = ($page * $per_page)-$per_page;
        $param['category_id'] = $category_id;

        $config['base_url'] = base_url('blog/category/'.$category_id);
        $config['total_rows'] = $this->Article_model->getArticlesCount($param);
        $config['uri_segment'] = 4;
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
        $articles = $this->Article_model->getArticlesFront($param);

        $data = [];
        $data['articles'] = $articles;
        $data['category'] = $category;
        $data['pagination_links'] = $pagination_links;

        $this->load->view('front/category_articles',$data);
    }
}
?>
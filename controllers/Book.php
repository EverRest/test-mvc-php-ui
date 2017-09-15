<?php

include 'models/Book_Model.php';
include 'models/Genre_Model.php';
include 'models/Author_Model.php';

class Book extends Controller
{
    protected $bmodel;
    protected $gmodel;
    protected $amodel;

    /**
     * Book constructor.
     * return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->bmodel = new Book_Model();
        $this->gmodel = new Genre_Model();
        $this->amodel = new Author_Model();
    }

    /**
     * Render list of all books.
     * return void
     */
    public function list()
    {

        // get all books
        $books = $this->bmodel->all();

        foreach ($books as &$book) {
            $book['author'] = $this->amodel->getName($book['author_id']);
            $book['genre'] = $this->gmodel->getName($book['genre_id']);
        }

        $this->view->assign($books);
        $this->view->render('book/list');
    }

    /**
     * Render create form.
     * return void
     */
    public function create()
    {
        $genres = $this->gmodel->getNames();
        $authors = $this->amodel->getNames();
        $this->view->assign(array('genres' => $genres, 'authors' => $authors));
        $this->view->render('book/create');
    }

    /**
     * Edit current book by id.
     * @param int $id
     * return void
     */
    public function edit($id = false)
    {
        // check is exists $id
        if($id) {
            $book = $this->bmodel->getById($id);

            $book['author'] = $this->amodel->getName($book['author_id']);
            $book['genre'] = $this->gmodel->getName($book['genre_id']);

            $genres = $this->gmodel->getNames();
            $authors = $this->amodel->getNames();
            $this->view->assign(array('book' => $book, 'genres' => $genres, 'authors' => $authors));

            $this->view->render('book/edit');
        } else {
            Helper::redirect('');
        }
    }

    /**
     * Render book details by id
     * @param int $id
     */
    public function detail($id = false)
    {
        // check is exists $id
        if($id) {
            $book = $this->bmodel->getById($id);

            $book['author'] = $this->amodel->getName($book['author_id']);
            $book['genre'] = $this->gmodel->getName($book['genre_id']);

            $genres = $this->gmodel->getNames();
            $authors = $this->amodel->getNames();
            $this->view->assign(array('book' => $book, 'genres' => $genres, 'authors' => $authors));

            $this->view->render('book/detail');
        } else {
            Helper::redirect('');
        }
    }

    /**
     * save the book
     * @param bool $id
     * return void
     */
    public function store($id = false)
    {

        // validate and clean post data
        if(!empty($_POST)) {

            $errors = array(
                'count' => 0,
                'messages' => array()
            );

            // cleaning POST array
            $post = XSS::clean($_POST);

            // check for create new or update book
            if($id)
            {
                $location = false;

                if (!empty($_FILES) && $_FILES['photo']['error'] == 0)
                {
                    $name = $_FILES['photo']['name'];
                    $size = $_FILES['photo']['size'];
                    $type = $_FILES['photo']['type'];
                    $extension = strtolower(substr($name, strpos($name, '.') + 1));
                    $tmp_name = $_FILES['photo']['tmp_name'];
                    $error = $_FILES['photo']['error'];

                    if(move_uploaded_file($tmp_name, 'uploads/' . $name . '.' . $extension))
                    {
                        $location =  'uploads/' . $name . '.' . $extension;
                    }

                }

                if (!empty($post['title']) && !empty($post['author'])
                    && !empty($post['genre']) && !empty($post['lang'])
                    && !empty($post['date']) && !empty($post['isbn'])
                    && !empty($post['book_id']) && $errors['count'] == 0)
                {
                    if($location) $post['photo'] = $location;

                    //check is valid ISBN code
                    if(!$this->isValidIsbn13($post['isbn'])) {
                        $errors['count']++;
                        $errors['messages']['isbn'] = 'Code is not valid by standart ISBN13';
                    }

                    if ($errors['count'] == 0) {
                        //save new book
                        $this->bmodel->update($post);
                        Helper::redirect('');
                    } else {
                        $book = $post;

                        $book['author'] = $this->amodel->getName($book['author']);
                        $book['genre'] = $this->gmodel->getName($book['genre']);

                        $genres = $this->gmodel->getNames();
                        $authors = $this->amodel->getNames();
                        $this->view->assign(
                            array(
                                'book' => $book,
                                'genres' => $genres,
                                'authors' => $authors,
                                'errors' => $errors
                            )
                        );

                        $this->view->render('book/edit');
                    }
                } else {

                    if( empty($post['title'])) $errors['count']++; $errors['message']['title'] = "The field title is required!";
                    if(empty($post['author']))  $errors['count']++; $errors['message']['author'] = "The field author is required!";
                    if(empty($post['genre']))  $errors['count']++; $errors['message']['genre'] = "The field genre is required!";
                    if(empty($post['lang']))  $errors['count']++; $errors['message']['lang'] = "The field language is required!";
                    if(empty($post['date']))  $errors['count']++; $errors['message']['date'] = "The field year is required!";
                    if(empty($post['isbn']))  $errors['count']++; $errors['message']['isbn'] = "The field year is required!";
                    $book = $post;

                    $book['author'] = $this->amodel->getName($book['author']);
                    $book['genre'] = $this->gmodel->getName($book['genre']);

                    $genres = $this->gmodel->getNames();
                    $authors = $this->amodel->getNames();
                    $this->view->assign(
                        array(
                            'book' => $book,
                            'genres' => $genres,
                            'authors' => $authors,
                            'errors' => $errors
                        )
                    );

                    $this->view->render('book/edit');
                }

            } else {

                //upload picture
                if (!empty($_FILES) && $_FILES['file']['error'] == 0) {
                    $name = $_FILES['photo']['name'];
                    $size = $_FILES['photo']['size'];
                    $type = $_FILES['photo']['type'];
                    $extension = strtolower(substr($name, strpos($name, '.') + 1));
                    $tmp_name = $_FILES['photo']['tmp_name'];
                    $error = $_FILES['photo']['error'];

                    $location =  'uploads/' . $name . '.' . $extension;
                    if(move_uploaded_file($tmp_name, $location))
                    {
                        if (!empty($post['title']) && !empty($post['author'])
                            && !empty($post['genre']) && !empty($post['lang'])
                            && !empty($post['date']) && !empty($post['isbn'])) {
                            $post['photo'] = $location;

                            //check is valid ISBN code
                            if(!$this->isValidIsbn13($post['isbn'])) {
                                $errors['count']++;
                                $errors['messages']['isbn'] = 'Code is not valid by standart ISBN13';
                            }


                            if ($errors['count'] == 0) {
                                //save new book
                                $this->bmodel->insert($post);
                                Helper::redirect('');
                            } else {
                                $book = $post;

//                                $book['author'] = $this->amodel->getName($book['author_id']);
//                                $book['genre'] = $this->gmodel->getName($book['genre_id']);

                                $genres = $this->gmodel->getNames();
                                $authors = $this->amodel->getNames();
                                $this->view->assign(
                                    array(
                                        'book' => $book,
                                        'genres' => $genres,
                                        'authors' => $authors,
                                        'errors' => $errors
                                    )
                                );

//                                echo '<pre>';print_r(array(
//                                    'book' => $book,
//                                    'genres' => $genres,
//                                    'authors' => $authors,
//                                    'errors' => $errors
//                                ));exit;

                                $this->view->render('book/create');
                            }
                        } else {
                            if( empty($post['title'])) $errors['count']++; $errors['message']['title'] = "The field title is required!";
                            if(empty($post['author']))  $errors['count']++; $errors['message']['author'] = "The field author is required!";
                            if(empty($post['genre']))  $errors['count']++; $errors['message']['genre'] = "The field genre is required!";
                            if(empty($post['lang']))  $errors['count']++; $errors['message']['lang'] = "The field language is required!";
                            if(empty($post['date']))  $errors['count']++; $errors['message']['date'] = "The field year is required!";
                            if(empty($post['isbn']))  $errors['count']++; $errors['message']['isbn'] = "The field year is required!";
                            $book = $post;

                            $book['author'] = $this->amodel->getName($book['author']);
                            $book['genre'] = $this->gmodel->getName($book['genre']);

                            $genres = $this->gmodel->getNames();
                            $authors = $this->amodel->getNames();
                            $this->view->assign(
                                array(
                                    'book' => $book,
                                    'genres' => $genres,
                                    'authors' => $authors,
                                    'errors' => $errors
                                )
                            );

                            $this->view->render('book/create');
                        }
                    } else {
                        $errors['count']++;
                        $errors['messages']['photo'] = 'Please load another picture.';

                        $book = $post;

                        $book['author'] = $this->amodel->getName($book['author_id']);
                        $book['genre'] = $this->gmodel->getName($book['genre_id']);

                        $genres = $this->gmodel->getNames();
                        $authors = $this->amodel->getNames();
                        $this->view->assign(
                            array(
                                'book' => $book,
                                'genres' => $genres,
                                'authors' => $authors,
                                'errors' => $errors
                            )
                        );

                        $this->view->render('book/create');
                    }

                } else {
                    die('Error: We got some problems with uploading your file!');
                }

            }
        } else {
            die('No data to save');
        }

    }

    /**
     * sorting the books by ajax
     * return void
     */
    public function sort()
    {
        $res = array(
               'error' => false,
                'books' => false,
                'message' => false
        );
        if(!empty($_POST) && !empty($_POST['type'])) {
            $type = ucwords($_POST['type']);
            $books = $this->bmodel->sortByTitle($type);
            foreach ($books as &$book) {
                $book['author'] = $this->amodel->getName($book['author_id']);
                $book['genre'] = $this->gmodel->getName($book['genre_id']);
            }
            $res['books'] = $books;
        } else {
            $res['error'] = true;
            $res['message'] = 'No data for sorting.';
        }

        echo json_encode($res);
    }

    /**
     *  ajax searching the books
     *  return void
     */
    public function search()
    {
        $res = array(
            'error' => false,
            'books' => false,
            'message' => false
        );
        if(!empty($_POST) && !empty($_POST['search'])) {

            // cleaning POST array
            $post = XSS::clean($_POST);

            $books = $this->bmodel->search($post['search']);
            foreach ($books as &$book) {
                $book['author'] = $this->amodel->getName($book['author_id']);
                $book['genre'] = $this->gmodel->getName($book['genre_id']);
            }
            $res['books'] = $books;
        } else {
            $res['error'] = true;
            $res['message'] = 'We have problems with search.';
        }

        echo json_encode($res);
    }

    /**
     * isbn13 standart validation
     * @param $str
     * @return bool
     */
    protected function isValidIsbn13($str)
    {
        $regex = '/\b(?:ISBN(?:: ?| ))?((?:97[89])?\d{9}[\dx])\b/i';

        if (preg_match($regex, str_replace('-', '', $str), $matches)) {
            if(13 !== strlen($matches[1])) return false;
            return true;
        }
        return false;
    }

    /**
     *  ajax counting all books
     *  return void
     */
    public function count()
    {
        $res = array();
        $count = $this->bmodel->countBooks();
        $res['count'] = $count[0];
        echo json_encode($res);
    }

    /**
     * ajax paginate books
     * @param int $page
     * @param int $current
     * return void
     */
    public function paginate( $page = 0, $current = 0)
    {
        $res = array(
            'error' => false,
            'books' => false,
            'page' => 0,
            'current' => 0,
            'message' => false
        );

        if(!empty($_GET) && !empty($_GET['page']) && !empty($_GET['current'])) {

            // cleaning GET array
            $get = Xss::clean($_GET);
            $page = intval($get['page']);
            $current = intval($get['current']);

            $res['page'] = $page;
            $page =3 * ($page - 1);

            $books = $this->bmodel->paginate($offset = $page);
            foreach ($books as &$book) {
                $book['author'] = $this->amodel->getName($book['author_id']);
                $book['genre'] = $this->gmodel->getName($book['genre_id']);
            }
            $res['books'] = $books;
        } else {
            $res['error'] = true;
            $res['message'] = 'No data for sorting.';
        }

        echo json_encode($res);
    }
}
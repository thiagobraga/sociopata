<?php

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Home
 * @author Thiago Braga <thiago@sociopata.org>
 * @access public
 * @version 1.0
 */
class Home extends Sociopata
{

    /**
     * Carrega a página inicial do site
     * @since 1.0
     */
    public function index()
    {
        $this->data = array_merge($this->data, array(
            'events'  => $this->getEvents(),
            'news'    => $this->getNews(),
            'albuns'  => $this->getAlbuns(),
            'photos'  => $this->getPhotos(),
            'page'    => 'Home',
            'content' => 'home/home'
        ));

        Sociopata::setTitle('Sociopata | ' . $this->data['page'] . ' | Bauru, SP - Som autoral desde 2008');
        Sociopata::setDescription('Confira as principais notícias e eventos.');
        Sociopata::loadCss(array(
            'bower_components/OwlCarousel/owl-carousel/owl.carousel',
            'bower_components/OwlCarousel/owl-carousel/owl.transitions',
            'bower_components/OwlCarousel/owl-carousel/owl.theme'
        ));

        $this->load->view('template', $this->data);
    }

    /**
     * [getEvents description]
     *
     * @return  [type]
     */
    public function getEvents()
    {
        $result = Eventos_model::getNextEvents();
        $result = $this->formatEvents($result);
        return $result;
    }

    /**
     * Format the display of events.
     *
     * @param   {Array}  $events  The events.
     * @return  {Array}
     */
    public function formatEvents($events)
    {
        foreach ($events as $i => $event) {
            $strtotime = strtotime($event->data);
            $month     = date('m', $strtotime);
            $day       = date('d', $strtotime);

            $events[$i]->month = monthName($month, true);
            $events[$i]->day   = $day;

            $events[$i]->url   = base_url('eventos#' . $event->slug);
        }

        return $events;
    }

    /**
     * API call news.
     *
     * @return  {Object}
     */
    public function getNews()
    {
        $query = array(
            'sociopatabr',
            '/posts',
            '?limit=4',
            '&fields=picture,message,created_time,link'
        );

        $news = $this->facebook->api(implode('', $query), 'GET');
        $news = $this->formatPosts($news);

        return $news['data'];
    }

    /**
     * [formatPosts description]
     *
     * @param   [type]  $news  [description]
     * @return  [type]
     */
    public function formatPosts($news)
    {
        foreach ($news['data'] as $i => $notice) {
            if (isset($notice['message'])) {
                $news['data'][$i]['message']      = str_replace("\n", '<br/>', $notice['message']);
                $news['data'][$i]['created_time'] = date('d/m/Y', strtotime($notice['created_time']));
            } else {
                unset($news['data'][$i]);
            }
        }

        return $news;
    }

    /**
     * [getAlbuns description]
     *
     * @return  [type]
     */
    public function getAlbuns()
    {
        $albuns = Home_model::getAlbuns();
        $musics = Home_model::getMusics();

        foreach ($albuns as $i => $album) {
            foreach ($musics as $j => $music) {
                if ($music->album == $album->codigo) {
                    $albuns[$i]->musics[$j] = $music;
                }
            }
        }

        return $albuns;
    }

    /**
     * [getMusics description]
     *
     * @param   string  $value  [description]
     * @return  [type]
     */
    public function getMusics($value='')
    {
        # code...
    }

    /**
     * [getPhotos description]
     *
     * @return  [type]
     */
    public function getPhotos()
    {
        $result = Home_model::getPhotos();
        return $result;
    }

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */

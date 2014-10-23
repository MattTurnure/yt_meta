<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Yt_meta Class
 *
 * @package     ExpressionEngine
 * @category    Plugin
 * @author      Matt Turnure
 * @copyright   Copyright (c) 2013, Matt Turnure
 * @link        http://mattturnure.com
 */

$plugin_info = array(
    'pi_name'         => 'YouTube Meta',
    'pi_version'      => '1.0',
    'pi_author'       => 'Matt Turnure',
    'pi_author_url'   => 'http://mattturnure.com',
    'pi_description'  => 'Returns Video title and description from video ID',
    'pi_usage'        => Yt_meta::usage()
);

class Yt_meta {
    // --------------------------------------------------------------------

    /**
     * Yt_meta
     *
     * Returns Video title and description from video ID
     *
     * @access  public
     * @return  string
     */

    public $return_data;

    private function getVideoAry($video_id) {
        $url = 'http://gdata.youtube.com/feeds/api/videos/' . $video_id . '?v=2&alt=json';
        $json_str = file_get_contents($url, 0, null, null);
        $json = json_decode($json_str, true);
        $video_title = $json['entry']['title']['$t'];
        $video_description = $json['entry']['media$group']['media$description']['$t'];
        $video_info_ary = array($video_title, $video_description);
        return $video_info_ary;
    }

    private function getVideoIndex($func, $index) {
        return $func[$index];
    }

    public function title() {
        $video_id = ee()->TMPL->fetch_param('video_id');

        if ($video_id !== '') {
            return $this->getVideoIndex($this->getVideoAry($video_id), 0);
        }
    }

    public function description() {
        $video_id = ee()->TMPL->fetch_param('video_id');

        if ($video_id !== '') {
            return $this->getVideoIndex($this->getVideoAry($video_id), 1);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Usage
     *
     * This function describes how the plugin is used.
     *
     * @access  public
     * @return  string
     */
    public static function usage()
    {
        ob_start();  ?>

Returns Video title and description from video ID.

    {exp:yt_meta:title video_id="{id}"}
    {exp:yt_meta:description video_id="{id}"}


    <?php
        $buffer = ob_get_contents();
        ob_end_clean();

        return $buffer;
    }
    // END
}

/* End of file pi.yt_meta.php */
/* Location: ./beforeitwascool/expressionengine/third_party/yt_meta/pi.yt_meta.php */

<?php

function smarty_function_user_albums($params, Smarty_Internal_Template $template) {

    $user_id = isset($params['user_id']) ? $params['user_id'] : 0;

    $ul = '<ul class="thumbnails">%s</ul>';
    $li = '<li class="span2">%s</li>';
    $image = '<a href="%s" class="thumbnail" rel="tooltip" title="%s"><img src="%s" /></a>';

    $em = Zend_Registry::get('doctrine')->getEntityManager();

    $query = $em->createQuery("SELECT a
                               FROM Champs\Entity\Album a, Champs\Entity\AlbumProfile ap, Champs\Entity\User u
                               WHERE ap.album = a and a.user = u and u.id = ?1 and ap.profile_key = 'privacy' and ap.profile_value = ?2
                               ORDER BY a.ts_created DESC");
    $query->setFirstResult(0)->setMaxResults(6)->setParameter(1, $user_id)->setParameter(2, \Champs\Entity\Repository\AlbumRepository::PRIVACY_PUBLIC);

    $result = $query->getResult();

    require_once $template->smarty->_get_plugin_filepath('function', 'imagefile');

    $albumLi = '';

    foreach ($result as $album) {
        $image_url = smarty_function_imagefile(array('id' => $album->photos->last()->id, 'w' => 200), $template);
        $album_url = sprintf('/%s/albums/%s/photos', $album->user->username, $album->id);
        $coverImage = sprintf($image, $album_url, $album->title, $image_url);

        $albumLi .= sprintf($li, $coverImage);
    }

    return sprintf($ul, $albumLi);
}
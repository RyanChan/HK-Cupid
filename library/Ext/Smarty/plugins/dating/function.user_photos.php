<?php

function smarty_function_user_photos ($params, Smarty_Internal_Template $template) {

    $user_id = isset($params['user_id']) ? $params['user_id'] : 0;

    $ul = '<ul class="thumbnails">%s</ul>';
    $li = '<li class="span2">%s</li>';
    $image = '<a href="%s" class="thumbnail" rel="tooltip" title="%s"><img src="%s" /></a>';

    $em = Zend_Registry::get('doctrine')->getEntityManager();

    $query = $em->createQuery("SELECT p
                               FROM Champs\Entity\Photo p, Champs\Entity\User u, Champs\Entity\Album a, Champs\Entity\AlbumProfile ap
                               WHERE p.user = u and u.id = ?1 and p.album = a and a.isProfileAlbum = 1 and ap.album = a and ap.profile_key = 'privacy' and ap.profile_value = ?2
                               ORDER BY p.ts_created DESC");

    $query->setFirstResult(0)->setMaxResults(6)->setParameter(1, $user_id)->setParameter(2, Champs\Entity\Repository\AlbumRepository::PRIVACY_PUBLIC);

    $result = $query->getResult();

    require_once $template->smarty->_get_plugin_filepath('function', 'imagefile');

    $photoLi = '';

    foreach ($result as $photo) {
        $image_url = smarty_function_imagefile(array('id' => $photo->id, 'w' => 200), $template);
        $user_url = sprintf('/%s/albums/%s/photos', $photo->user->username, $photo->album->id);
        $newImage = sprintf($image, $user_url, $photo->album->title, $image_url);

        $photoLi .= sprintf($li, $newImage);
    }

    return sprintf($ul, $photoLi);
}
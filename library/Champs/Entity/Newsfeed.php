<?php
namespace Champs\Entity;

/**
 * @Entity
 * @Table(name="newsfeeds")
 * @HasLifecycleCallbacks
 */
class Newsfeed{
    private $id;
    private $user;
    private $content;
    private $ts_created;
    private $ts_last_updated;
    private $profiles;
}
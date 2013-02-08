<div class="container">
    <div class="row-fluid">
        <div class="span9">
            <div class="row-fluid">
                <div class="span3">
                    <div id="gallery" data-toggle="modal-gallery" data-target="#modal-gallery">
                        <a href="{imagefile id=$user->getProfileAlbum()->photos->last()->id}" data-gallery="gallery">
                            <img data-src="holder.js/270x310" src="{imagefile id=$user->getProfileAlbum()->photos->last()->id height=270}" height="270" class="img-polaroid" />
                        </a>
                    </div>

                    {gallery}
                </div>

                <div class="span9">
                    <h3>{$user->getProfile('nickname')|capitalize:false} {if $user->getAge() != null}({$user->getAge()}){/if}</h3>
                    <hr />
                    <dl>
                        {if $user->getProfile('first_name') && $user->getProfile('last_name')}
                            <dt>{translate name="Real Name"}</dt>
                            <dd>{$user->getProfile('first_name')|escape}, {$user->getProfile('last_name')|escape}</dd>
                        {/if}
                        {if $user->getProfile('birthday')}
                            <dt>{translate name="Birthday"}</dt>
                            <dd>{$user->getProfile('birthday')|date_format:"%B %e, %Y"}</dd>
                        {/if}
                        {if $user->getProfile('email')}
                            <dt>{translate name="Email Address"}</dt>
                            <dd><a href="mailto:{$user->getProfile('email')|escape}">{$user->getProfile('email')|escape}&nbsp;<i class="icon-envelope"></i></a></dd>
                        {/if}
                        {if $user->getProfile('gender')}
                            <dt>{translate name="Gender"}</dt>
                            <dd>{$user->getGender()|escape}</dd>
                        {/if}
                    </dl>

                    <a href="#" rel="tooltip" title="{translate name="Not Available"}" class="btn"><i class="iconic-heart"></i>&nbsp;{translate name="Like"}</a>
                    <a {if !$user->isFollowed()} href="{geturl controller="dating" action="addfollower"}/{$user->username|escape}" {/if} rel="tooltip" title="{if $user->isFollowed()} {translate name="Followed"} {else} {translate name="Follow this member"} {/if}" class="btn btn-info {if $user->isFollowed()}disabled{/if}">
                        <i class="iconic-star"></i>&nbsp;
                        {if $user->isFollowed()}
                            {translate name="Followed"}
                        {else}
                            {translate name="Follow"}
                        {/if}
                    </a>
                    <a id="message-compose-send" rel="tooltip" title="{translate name="Send message to this user."}" class="btn btn-primary"><i class="iconic-mail"></i>&nbsp;{translate name="Send Message"}</a>
                    {include file="message_compose.tpl" receiver=$user controller=$controller action=$action username=$user->username}

                </div>
            </div>
            <hr />
            <div class="row-fluid">
                <div class="span12">
                    <h4>{translate name="Intro"}</h4>
                    <hr />
                    <div>
                        <blockquote>
                            {$user->getProfile('intro')}
                        </blockquote>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span6">
                    <h4>{translate name="Other Info"}</h4>
                    <hr />
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>{translate name="Body Type"}</td>
                                <td>
                                    {if $user->getProfile('bodytype') != null}
                                        {user_details type="bodytype" key=$user->getProfile('bodytype')}
                                    {else}
                                        {translate name="Not specified"}
                                    {/if}
                                </td>
                            </tr>
                            <tr>
                                <td>{translate name="Smoke"}</td>
                                <td>
                                    {if $user->getProfile('smoking') != null}
                                        {user_details type="smoking" key=$user->getProfile('smoking')}
                                    {else}
                                        {translate name="Not specified"}
                                    {/if}
                                </td>
                            </tr>
                            <tr>
                                <td>{translate name="Drinking"}</td>
                                <td>
                                    {if $user->getProfile('drinking') != null}
                                        {user_details type="drinking" key=$user->getProfile('drinking')}
                                    {else}
                                        {translate name="Not specified"}
                                    {/if}
                                </td>
                            </tr>
                            <tr>
                                <td>{translate name="Resting"}</td>
                                <td>
                                    {if $user->getProfile('resting') != null}
                                        {user_details type="resting" key=$user->getProfile('resting')}
                                    {else}
                                        {translate name="Not specified"}
                                    {/if}
                                </td>
                            </tr>
                            <tr>
                                <td>{translate name="Education"}</td>
                                <td>
                                    {if $user->getProfile('education') != null}
                                        {user_details type="educationlist" key=$user->getProfile('education')}
                                    {else}
                                        {translate name="Not specified"}
                                    {/if}
                                </td>
                            </tr>
                            <tr>
                                <td>{translate name="Profession"}</td>
                                <td>
                                    {if $user->getProfile('profession') != null}
                                        {user_details type="profession" key=$user->getProfile('profession')}
                                    {else}
                                        {translate name="Not specified"}
                                    {/if}
                                </td>
                            </tr>
                            <tr>
                                <td>{translate name="Occupation"}</td>
                                <td>
                                    {if $user->getProfile('occupation') != null}
                                        {user_details type="occupation" key=$user->getProfile('occupation')}
                                    {else}
                                        {translate name="Not specified"}
                                    {/if}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="span6">
                    <h4>{translate name="Target Require"}</h4>
                    <hr />
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>{translate name="Body Type"}</td>
                                <td>
                                    {if $user->getProfile('bodytype') != null}
                                        {user_details type="bodytype" key=$user->getProfile('bodytype')}
                                    {else}
                                        {translate name="Not specified"}
                                    {/if}
                                </td>
                            </tr>
                            <tr>
                                <td>{translate name="Smoke"}</td>
                                <td>
                                    {if $user->getProfile('smoking') != null}
                                        {user_details type="smoking" key=$user->getProfile('smoking')}
                                    {else}
                                        {translate name="Not specified"}
                                    {/if}
                                </td>
                            </tr>
                            <tr>
                                <td>{translate name="Drinking"}</td>
                                <td>
                                    {if $user->getProfile('drinking') != null}
                                        {user_details type="drinking" key=$user->getProfile('drinking')}
                                    {else}
                                        {translate name="Not specified"}
                                    {/if}
                                </td>
                            </tr>
                            <tr>
                                <td>{translate name="Resting"}</td>
                                <td>
                                    {if $user->getProfile('resting') != null}
                                        {user_details type="resting" key=$user->getProfile('resting')}
                                    {else}
                                        {translate name="Not specified"}
                                    {/if}
                                </td>
                            </tr>
                            <tr>
                                <td>{translate name="Education"}</td>
                                <td>
                                    {if $user->getProfile('education') != null}
                                        {user_details type="educationlist" key=$user->getProfile('education')}
                                    {else}
                                        {translate name="Not specified"}
                                    {/if}
                                </td>
                            </tr>
                            <tr>
                                <td>{translate name="Profession"}</td>
                                <td>
                                    {if $user->getProfile('profession') != null}
                                        {user_details type="profession" key=$user->getProfile('profession')}
                                    {else}
                                        {translate name="Not specified"}
                                    {/if}
                                </td>
                            </tr>
                            <tr>
                                <td>{translate name="Occupation"}</td>
                                <td>
                                    {if $user->getProfile('occupation') != null}
                                        {user_details type="occupation" key=$user->getProfile('occupation')}
                                    {else}
                                        {translate name="Not specified"}
                                    {/if}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            {*
            <div class="row-fluid">
                <div class="span12">
                    <h4>{translate name="Recent Status"}</h4>
                    <hr />
                </div>
            </div>
            *}
            <div class="row-fluid">
                <div class="span12">
                    <h4>{translate name="Recent Photos"}</h4>
                    <hr />
                    {user_photos user_id=$user->id}
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <h4>{translate name="Recent Albums"}</h4>
                    <hr />
                    {user_albums user_id=$user->id}
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <h4>{translate name="Followers"}</h4>
                    <hr />
                    {user_followers user_id=$user->id}
                </div>
            </div>
        </div>

        <div class="span3">
            
        </div>

    </div>
</div>
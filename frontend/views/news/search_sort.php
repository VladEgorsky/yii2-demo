<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 07.01.19
 * Time: 22:36
 */

?>

<div class="sort_by">
    <span>Sort by:</span>

    <div class="more">
        <span class="open_more_list">Views</span>
        <ul>
            <div class="item">
                <input name="sort_by" type="radio" class="checkbox" id="views" value="1" checked/>
                <label for="views">Views</label>
            </div>

            <div class="item">
                <input name="sort_by" type="radio" class="checkbox" id="comments" value="2"/>
                <label for="comments">Comments</label>
            </div>

            <div class="item">
                <input name="sort_by" type="radio" class="checkbox" id="new" value="3"/>
                <label for="new">New</label>
            </div>

            <div class="item">
                <input name="sort_by" type="radio" class="checkbox" id="old" value="4"/>
                <label for="old">Old</label>
            </div>
        </ul>
    </div>
</div>


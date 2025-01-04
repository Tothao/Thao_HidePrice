<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Thao\Blog\Api\Data;

interface PostInterface
{

    const IMAGE = 'image';
    const STORE_ID = 'store_id';
    const TITLE = 'title';
    const AUTHOR = 'author';
    const IS_ACTIVE = 'is_active';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const CONTENT = 'content';
    const POST_ID = 'post_id';
    const URL_KEY = 'url_key';

    /**
     * Get post_id
     * @return string|null
     */
    public function getPostId();

    /**
     * Set post_id
     * @param string $postId
     * @return \Thao\Blog\Post\Api\Data\PostInterface
     */
    public function setPostId($postId);

    /**
     * Get title
     * @return string|null
     */
    public function getTitle();

    /**
     * Set title
     * @param string $title
     * @return \Thao\Blog\Post\Api\Data\PostInterface
     */
    public function setTitle($title);

    /**
     * Get is_active
     * @return string|null
     */
    public function getIsActive();

    /**
     * Set is_active
     * @param string $isActive
     * @return \Thao\Blog\Post\Api\Data\PostInterface
     */
    public function setIsActive($isActive);

    /**
     * Get image
     * @return string|null
     */
    public function getImage();

    /**
     * Set image
     * @param string $image
     * @return \Thao\Blog\Post\Api\Data\PostInterface
     */
    public function setImage($image);

    /**
     * Get url_key
     * @return string|null
     */
    public function getUrlKey();

    /**
     * Set url_key
     * @param string $urlKey
     * @return \Thao\Blog\Post\Api\Data\PostInterface
     */
    public function setUrlKey($urlKey);

    /**
     * Get author
     * @return string|null
     */
    public function getAuthor();

    /**
     * Set author
     * @param string $author
     * @return \Thao\Blog\Post\Api\Data\PostInterface
     */
    public function setAuthor($author);

    /**
     * Get content
     * @return string|null
     */
    public function getContent();

    /**
     * Set content
     * @param string $content
     * @return \Thao\Blog\Post\Api\Data\PostInterface
     */
    public function setContent($content);

    /**
     * Get store_id
     * @return string|null
     */
    public function getStoreId();

    /**
     * Set store_id
     * @param string $storeId
     * @return \Thao\Blog\Post\Api\Data\PostInterface
     */
    public function setStoreId($storeId);

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Thao\Blog\Post\Api\Data\PostInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * Get updated_at
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set updated_at
     * @param string $updatedAt
     * @return \Thao\Blog\Post\Api\Data\PostInterface
     */
    public function setUpdatedAt($updatedAt);
}


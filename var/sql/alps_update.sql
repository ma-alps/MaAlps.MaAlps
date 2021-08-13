/* Update ALPS item */
UPDATE alps
   SET is_public = :isPublic,
       title = :title,
       asd_url = :asdUrl,
       profile_url = :profileUrl,
       media_type = :mediaType
 WHERE id = :id
   AND user_id = :userId

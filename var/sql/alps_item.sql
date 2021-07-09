/* ALPS item */
SELECT id, is_public, title, user_id, asd_url, profile_url, media_type
  FROM alps
 WHERE id = :id;

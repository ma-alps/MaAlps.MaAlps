/* Delete ALPS item */
DELETE
  FROM alps
 WHERE id = :id
   AND user_id = :userId

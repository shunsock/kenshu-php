CREATE USER docker;
CREATE DATABASE docker;
GRANT ALL PRIVILEGES ON DATABASE docker TO docker;
\c docker
CREATE TABLE "user" (
    "id" SERIAL PRIMARY KEY,
    "name" VARCHAR(80) NOT NULL,
    "email" VARCHAR(32) NT NULL,
    "password" VARCHAR(32) NOT NULL,
    "created_at" TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
    "updated_at" TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
    "deleted_at" TIMESTAMPTZ
);

CREATE TABLE "post" (
    "id" SERIAL PRIMARY KEY,
    "title" VARCHAR(255) NOT NULL,
    "user_id" INT NOT NULL,
    "thumbnail" VARCHAR(128) NOT NULL,
    "body" BYTEA NOT NULL,
    "created_at" TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
    "updated_at" TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE "image" (
     "id" SERIAL PRIMARY KEY,
     "post_id" INT NOT NULL,
     "path" VARCHAR(128) NOT NULL
);

CREATE TABLE "tag" (
   "tag_id" SERIAL NOT NULL,
   "post_id" INT NOT NULL,
   PRIMARY KEY ("tag_id", "post_id")
);

CREATE TABLE "tag_name" (
    "id" SERIAL PRIMARY KEY,
    "name" VARCHAR(64) NOT NULL
);

ALTER TABLE "post" ADD FOREIGN KEY ("user_id") REFERENCES "user" ("id");

ALTER TABLE "image" ADD FOREIGN KEY ("post_id") REFERENCES "post" ("id");

ALTER TABLE "tag" ADD FOREIGN KEY ("post_id") REFERENCES "post" ("id");

ALTER TABLE "tag" ADD FOREIGN KEY ("tag_id") REFERENCES "tag_name" ("id");
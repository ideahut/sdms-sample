/*
 Navicat Premium Data Transfer

 Source Server         : POSTGRE
 Source Server Type    : PostgreSQL
 Source Server Version : 110002
 Source Host           : localhost:5432
 Source Catalog        : slim_doctrine_db
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 110002
 File Encoding         : 65001

 Date: 04/04/2019 23:11:38
*/


-- ----------------------------
-- Sequence structure for t_test_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."t_test_id_seq";
CREATE SEQUENCE "public"."t_test_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for t_user_id__seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."t_user_id__seq";
CREATE SEQUENCE "public"."t_user_id__seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for t_access
-- ----------------------------
DROP TABLE IF EXISTS "public"."t_access";
CREATE TABLE "public"."t_access" (
  "f_user" int8,
  "key_" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "validation" varchar(2048) COLLATE "pg_catalog"."default" NOT NULL,
  "expiration" int8 NOT NULL DEFAULT 0,
  "created_at_" timestamp(0) NOT NULL,
  "updated_at_" timestamp(0) NOT NULL
)
;

-- ----------------------------
-- Records of t_access
-- ----------------------------
INSERT INTO "public"."t_access" VALUES (1, 'c6837fd9-1c45-498b-baf0-e39535af687d', '127.0.0.1 PostmanRuntime/7.6.1', 1554480204113, '2019-04-04 23:03:07', '2019-04-04 23:05:01');

-- ----------------------------
-- Table structure for t_test
-- ----------------------------
DROP TABLE IF EXISTS "public"."t_test";
CREATE TABLE "public"."t_test" (
  "id" int8 NOT NULL DEFAULT nextval('t_test_id_seq'::regclass),
  "name" varchar(32) COLLATE "pg_catalog"."default" NOT NULL
)
;

-- ----------------------------
-- Table structure for t_user
-- ----------------------------
DROP TABLE IF EXISTS "public"."t_user";
CREATE TABLE "public"."t_user" (
  "username" varchar(64) COLLATE "pg_catalog"."default" NOT NULL,
  "password" varchar(128) COLLATE "pg_catalog"."default" NOT NULL,
  "fullname" varchar(128) COLLATE "pg_catalog"."default" NOT NULL,
  "phone" varchar(128) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
  "email" varchar(255) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
  "address" varchar(255) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
  "status" int2 NOT NULL DEFAULT 1,
  "role" int2 NOT NULL DEFAULT 1,
  "photo" varchar(1024) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
  "id_" int8 NOT NULL DEFAULT nextval('t_user_id__seq'::regclass),
  "version_" int8 NOT NULL DEFAULT 1,
  "created_at_" timestamp(0) NOT NULL,
  "updated_at_" timestamp(0) NOT NULL
)
;

-- ----------------------------
-- Records of t_user
-- ----------------------------
INSERT INTO "public"."t_user" VALUES ('admin', '41e5653fc7aeb894026d6bb7b2db7f65902b454945fa8fd65a6327047b5277fb', 'Admin', NULL, NULL, NULL, 1, 0, NULL, 1, 1, '2019-04-04 22:46:47', '2019-04-04 22:46:51');

-- ----------------------------
-- Function structure for uuid_generate_v1
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_generate_v1"();
CREATE OR REPLACE FUNCTION "public"."uuid_generate_v1"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_generate_v1'
  LANGUAGE c VOLATILE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_generate_v1mc
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_generate_v1mc"();
CREATE OR REPLACE FUNCTION "public"."uuid_generate_v1mc"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_generate_v1mc'
  LANGUAGE c VOLATILE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_generate_v3
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_generate_v3"("namespace" uuid, "name" text);
CREATE OR REPLACE FUNCTION "public"."uuid_generate_v3"("namespace" uuid, "name" text)
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_generate_v3'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_generate_v4
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_generate_v4"();
CREATE OR REPLACE FUNCTION "public"."uuid_generate_v4"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_generate_v4'
  LANGUAGE c VOLATILE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_generate_v5
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_generate_v5"("namespace" uuid, "name" text);
CREATE OR REPLACE FUNCTION "public"."uuid_generate_v5"("namespace" uuid, "name" text)
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_generate_v5'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_nil
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_nil"();
CREATE OR REPLACE FUNCTION "public"."uuid_nil"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_nil'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_ns_dns
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_ns_dns"();
CREATE OR REPLACE FUNCTION "public"."uuid_ns_dns"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_ns_dns'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_ns_oid
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_ns_oid"();
CREATE OR REPLACE FUNCTION "public"."uuid_ns_oid"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_ns_oid'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_ns_url
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_ns_url"();
CREATE OR REPLACE FUNCTION "public"."uuid_ns_url"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_ns_url'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Function structure for uuid_ns_x500
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."uuid_ns_x500"();
CREATE OR REPLACE FUNCTION "public"."uuid_ns_x500"()
  RETURNS "pg_catalog"."uuid" AS '$libdir/uuid-ossp', 'uuid_ns_x500'
  LANGUAGE c IMMUTABLE STRICT
  COST 1;

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."t_test_id_seq"
OWNED BY "public"."t_test"."id";
SELECT setval('"public"."t_test_id_seq"', 2, false);
ALTER SEQUENCE "public"."t_user_id__seq"
OWNED BY "public"."t_user"."id_";
SELECT setval('"public"."t_user_id__seq"', 3, true);

-- ----------------------------
-- Indexes structure for table t_access
-- ----------------------------
CREATE INDEX "idx_2f0e53aa79fb1cab" ON "public"."t_access" USING btree (
  "f_user" "pg_catalog"."int8_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table t_access
-- ----------------------------
ALTER TABLE "public"."t_access" ADD CONSTRAINT "t_access_pkey" PRIMARY KEY ("key_");

-- ----------------------------
-- Primary Key structure for table t_test
-- ----------------------------
ALTER TABLE "public"."t_test" ADD CONSTRAINT "t_test_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table t_user
-- ----------------------------
CREATE INDEX "login_idx" ON "public"."t_user" USING btree (
  "username" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST,
  "password" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE UNIQUE INDEX "uniq_37e5bf3bf85e0677" ON "public"."t_user" USING btree (
  "username" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table t_user
-- ----------------------------
ALTER TABLE "public"."t_user" ADD CONSTRAINT "t_user_pkey" PRIMARY KEY ("id_");

-- ----------------------------
-- Foreign Keys structure for table t_access
-- ----------------------------
ALTER TABLE "public"."t_access" ADD CONSTRAINT "fk_2f0e53aa79fb1cab" FOREIGN KEY ("f_user") REFERENCES "public"."t_user" ("id_") ON DELETE CASCADE ON UPDATE NO ACTION;

/*
 Navicat Premium Data Transfer

 Source Server         : SQLServer
 Source Server Type    : SQL Server
 Source Server Version : 13004001
 Source Host           : 127.0.0.1:1433
 Source Catalog        : slim_doctrine_db
 Source Schema         : dbo

 Target Server Type    : SQL Server
 Target Server Version : 13004001
 File Encoding         : 65001

 Date: 04/04/2019 00:50:35
*/


-- ----------------------------
-- Table structure for t_access
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[t_access]') AND type IN ('U'))
	DROP TABLE [dbo].[t_access]
GO

CREATE TABLE [dbo].[t_access] (
  [f_user] bigint  NULL,
  [KEY_] nvarchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS  NOT NULL,
  [validation] nvarchar(2048) COLLATE SQL_Latin1_General_CP1_CI_AS  NOT NULL,
  [expiration] bigint DEFAULT ((0)) NOT NULL,
  [CREATED_AT_] datetime2(6)  NOT NULL,
  [UPDATED_AT_] datetime2(6)  NOT NULL
)
GO

ALTER TABLE [dbo].[t_access] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of t_access
-- ----------------------------
INSERT INTO [dbo].[t_access]  VALUES (N'1', N'5979553A-E698-4AB5-8BB3-6A035AC57507', N'127.0.0.1 PostmanRuntime/7.6.1', N'1554399750542', N'2019-04-04 00:32:54.215000', N'2019-04-04 00:42:30.541000')
GO


-- ----------------------------
-- Table structure for t_test
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[t_test]') AND type IN ('U'))
	DROP TABLE [dbo].[t_test]
GO

CREATE TABLE [dbo].[t_test] (
  [id] bigint  IDENTITY(1,1) NOT NULL,
  [name] nvarchar(32) COLLATE SQL_Latin1_General_CP1_CI_AS  NOT NULL
)
GO

ALTER TABLE [dbo].[t_test] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Table structure for t_user
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[t_user]') AND type IN ('U'))
	DROP TABLE [dbo].[t_user]
GO

CREATE TABLE [dbo].[t_user] (
  [username] nvarchar(64) COLLATE SQL_Latin1_General_CP1_CI_AS  NOT NULL,
  [password] nvarchar(128) COLLATE SQL_Latin1_General_CP1_CI_AS  NOT NULL,
  [fullname] nvarchar(128) COLLATE SQL_Latin1_General_CP1_CI_AS  NOT NULL,
  [phone] nvarchar(128) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [email] nvarchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [address] nvarchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [status] smallint DEFAULT ((1)) NOT NULL,
  [role] smallint DEFAULT ((1)) NOT NULL,
  [photo] nvarchar(1024) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [ID_] bigint  IDENTITY(1,1) NOT NULL,
  [VERSION_] bigint DEFAULT ((1)) NOT NULL,
  [CREATED_AT_] datetime2(6)  NOT NULL,
  [UPDATED_AT_] datetime2(6)  NOT NULL
)
GO

ALTER TABLE [dbo].[t_user] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of t_user
-- ----------------------------
SET IDENTITY_INSERT [dbo].[t_user] ON
GO

INSERT INTO [dbo].[t_user] ([username], [password], [fullname], [phone], [email], [address], [status], [role], [photo], [ID_], [VERSION_], [CREATED_AT_], [UPDATED_AT_]) VALUES (N'admin', N'41e5653fc7aeb894026d6bb7b2db7f65902b454945fa8fd65a6327047b5277fb', N'Admin', NULL, NULL, NULL, N'1', N'0', NULL, N'1', N'1', N'2019-04-04 00:31:31.000000', N'2019-04-04 00:31:35.000000')
GO

SET IDENTITY_INSERT [dbo].[t_user] OFF
GO


-- ----------------------------
-- Indexes structure for table t_access
-- ----------------------------
CREATE NONCLUSTERED INDEX [IDX_2F0E53AA79FB1CAB]
ON [dbo].[t_access] (
  [f_user] ASC
)
GO

CREATE NONCLUSTERED INDEX [key_idx]
ON [dbo].[t_access] (
  [KEY_] ASC
)
GO


-- ----------------------------
-- Primary Key structure for table t_access
-- ----------------------------
ALTER TABLE [dbo].[t_access] ADD CONSTRAINT [PK__t_access__6AF90CE3052C012F] PRIMARY KEY CLUSTERED ([KEY_])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Indexes structure for table t_test
-- ----------------------------
CREATE NONCLUSTERED INDEX [id_idx]
ON [dbo].[t_test] (
  [id] ASC
)
GO


-- ----------------------------
-- Primary Key structure for table t_test
-- ----------------------------
ALTER TABLE [dbo].[t_test] ADD CONSTRAINT [PK__t_test__3213E83F92FD28B6] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Indexes structure for table t_user
-- ----------------------------
CREATE UNIQUE NONCLUSTERED INDEX [UNIQ_37E5BF3BF85E0677]
ON [dbo].[t_user] (
  [username] ASC
)
WHERE ([username] IS NOT NULL)
GO

CREATE NONCLUSTERED INDEX [id_idx]
ON [dbo].[t_user] (
  [ID_] ASC
)
GO

CREATE NONCLUSTERED INDEX [login_idx]
ON [dbo].[t_user] (
  [username] ASC,
  [password] ASC
)
GO


-- ----------------------------
-- Primary Key structure for table t_user
-- ----------------------------
ALTER TABLE [dbo].[t_user] ADD CONSTRAINT [PK__t_user__C4971C0F2011FE12] PRIMARY KEY CLUSTERED ([ID_])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Foreign Keys structure for table t_access
-- ----------------------------
ALTER TABLE [dbo].[t_access] ADD CONSTRAINT [FK_2F0E53AA79FB1CAB] FOREIGN KEY ([f_user]) REFERENCES [dbo].[t_user] ([ID_]) ON DELETE CASCADE ON UPDATE NO ACTION
GO


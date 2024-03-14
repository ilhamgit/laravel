using System.Collections.Generic;
using Microsoft.EntityFrameworkCore;
using SonicAPI.Models.DbSets;

namespace SonicAPI.Models
{
    public class SonicContext : DbContext
    {
        public SonicContext(DbContextOptions<SonicContext> options)
            : base(options)
        { }
        protected override void OnModelCreating(ModelBuilder modelBuilder)
        {
            modelBuilder.Entity<Admin>().Property(c => c.DateCreated).ValueGeneratedOnAdd();
            modelBuilder.Entity<Admin>().Property(c => c.DateModified).ValueGeneratedOnAdd();
            modelBuilder.Entity<GameCharacter>().Property(c => c.DateCreated).ValueGeneratedOnAdd();
            modelBuilder.Entity<GameCharacter>().Property(c => c.DateModified).ValueGeneratedOnAdd();
            modelBuilder.Entity<GameCoin>().Property(c => c.DateCreated).ValueGeneratedOnAdd();
            modelBuilder.Entity<GameCoin>().Property(c => c.DateModified).ValueGeneratedOnAdd();
            modelBuilder.Entity<GameCoinRule>().Property(c => c.DateCreated).ValueGeneratedOnAdd();
            modelBuilder.Entity<GameCoinRule>().Property(c => c.DateModified).ValueGeneratedOnAdd();
            modelBuilder.Entity<GameItem>().Property(c => c.DateCreated).ValueGeneratedOnAdd();
            modelBuilder.Entity<GameItem>().Property(c => c.DateModified).ValueGeneratedOnAdd();
            modelBuilder.Entity<GameItemRule>().Property(c => c.DateCreated).ValueGeneratedOnAdd();
            modelBuilder.Entity<GameItemRule>().Property(c => c.DateModified).ValueGeneratedOnAdd();
            modelBuilder.Entity<GameMatch>().Property(c => c.DateCreated).ValueGeneratedOnAdd();
            modelBuilder.Entity<GameMatch>().Property(c => c.DateModified).ValueGeneratedOnAdd();
            modelBuilder.Entity<GameMatchDetail>().Property(c => c.DateCreated).ValueGeneratedOnAdd();
            modelBuilder.Entity<GameMatchDetail>().Property(c => c.DateModified).ValueGeneratedOnAdd();
            modelBuilder.Entity<GameMode>().Property(c => c.DateCreated).ValueGeneratedOnAdd();
            modelBuilder.Entity<GameMode>().Property(c => c.DateModified).ValueGeneratedOnAdd();
            modelBuilder.Entity<GameModeRule>().Property(c => c.DateCreated).ValueGeneratedOnAdd();
            modelBuilder.Entity<GameModeRule>().Property(c => c.DateModified).ValueGeneratedOnAdd();
            modelBuilder.Entity<GameReward>().Property(c => c.DateCreated).ValueGeneratedOnAdd();
            modelBuilder.Entity<GameReward>().Property(c => c.DateModified).ValueGeneratedOnAdd();
            modelBuilder.Entity<GameRewardAttribute>().Property(c => c.DateCreated).ValueGeneratedOnAdd();
            modelBuilder.Entity<GameRewardAttribute>().Property(c => c.DateModified).ValueGeneratedOnAdd();
            modelBuilder.Entity<GameSparePart>().Property(c => c.DateCreated).ValueGeneratedOnAdd();
            modelBuilder.Entity<GameSparePart>().Property(c => c.DateModified).ValueGeneratedOnAdd();
            modelBuilder.Entity<GameSparePartAttribute>().Property(c => c.DateCreated).ValueGeneratedOnAdd();
            modelBuilder.Entity<GameSparePartAttribute>().Property(c => c.DateModified).ValueGeneratedOnAdd();
            modelBuilder.Entity<User>().Property(c => c.DateCreated).ValueGeneratedOnAdd();
            modelBuilder.Entity<User>().Property(c => c.DateModified).ValueGeneratedOnAdd();
            modelBuilder.Entity<UserAttribute>().Property(c => c.DateCreated).ValueGeneratedOnAdd();
            modelBuilder.Entity<UserAttribute>().Property(c => c.DateModified).ValueGeneratedOnAdd();
            modelBuilder.Entity<UserCharacter>().Property(c => c.DateCreated).ValueGeneratedOnAdd();
            modelBuilder.Entity<UserCharacter>().Property(c => c.DateModified).ValueGeneratedOnAdd();
            modelBuilder.Entity<UserCoin>().Property(c => c.DateCreated).ValueGeneratedOnAdd();
            modelBuilder.Entity<UserCoin>().Property(c => c.DateModified).ValueGeneratedOnAdd();
            modelBuilder.Entity<UserLoginHistory>().Property(c => c.DateCreated).ValueGeneratedOnAdd();
            modelBuilder.Entity<UserLoginHistory>().Property(c => c.DateModified).ValueGeneratedOnAdd();
            modelBuilder.Entity<UserSparePart>().Property(c => c.DateCreated).ValueGeneratedOnAdd();
            modelBuilder.Entity<UserSparePart>().Property(c => c.DateModified).ValueGeneratedOnAdd();
            modelBuilder.Entity<UserStamina>().Property(c => c.DateCreated).ValueGeneratedOnAdd();
            modelBuilder.Entity<UserStamina>().Property(c => c.DateModified).ValueGeneratedOnAdd();
        }
        public DbSet<Admin> Admins { get; set; }
        public DbSet<GameCharacter> GameCharacters { get; set; }
        public DbSet<GameCoin> GameCoins { get; set; }
        public DbSet<GameCoinRule> GameCoinRules { get; set; }
        public DbSet<GameItem> GameItems { get; set; }
        public DbSet<GameItemRule> GameItemRules { get; set; }
        public DbSet<GameMatch> GameMatches { get; set; }
        public DbSet<GameMatchDetail> GameMatchDetails { get; set; }
        public DbSet<GameMode> GameModes { get; set; }
        public DbSet<GameModeRule> GameModeRules { get; set; }
        public DbSet<GameReward> GameRewards { get; set; }
        public DbSet<GameRewardAttribute> GameRewardAttributes { get; set; }
        public DbSet<GameSparePart> GameSpareParts { get; set; }
        public DbSet<GameSparePartAttribute> GameSparePartAttributes { get; set; }
        public DbSet<User> Users { get; set; }
        public DbSet<UserAttribute> UserAttributes { get; set; }
        public DbSet<UserCharacter> UserCharacters { get; set; }
        public DbSet<UserCoin> UserCoins { get; set; }
        public DbSet<UserLoginHistory> UserLoginHistory { get; set; }
        public DbSet<UserSparePart> UserSpareParts { get; set; }
        public DbSet<UserStamina> UserStamina { get; set; }
    }
}
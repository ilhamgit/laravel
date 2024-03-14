using SonicAPI.Models.DataModels;
using SonicAPI.Models.DbSets;
using System;
using System.Collections.Generic;
using System.Threading.Tasks;

namespace SonicAPI.Interfaces
{
    public interface IBaseService
    {
        Task<User> GetUserByUsername(string username);
        Task<User> GetUserByNftUserId(string nftUserId);
        Task<User> GetUserByNftAddress(string nftAddress);
        Task<User> GetUserByNftAddressAsNoTracking(string nftAddress);
        Task<User> GetUserAsNoTracking(long id);
        Task<User> GetUser(long id);
        Task<bool> InsertUser(string userNftAddress, string userNftId, string username, string email);
        Task<bool> UpdateUserCharactersIsOccupied(List<UserCharacter> list);
        Task<bool> UpdateUserSparePartsIsOccupied(List<UserSparePart> list);
        Task<bool> InsertUserCharacter(User item, GameCharacter nftItem);
        Task<bool> InsertUserCharacters(long id, List<string> list);
        Task<bool> InsertUserSparePart(User item, GameSparePart nftItem);
        Task<bool> InsertUserSpareParts(long id, List<string> list);
        Task<bool> UpdateUserCharacter(User item, UserCharacter nftItem);
        Task<bool> UpdateUserSparePart(User item, UserSparePart nftItem);
        Task<bool> DeleteUserCharacters(List<UserCharacter> list);
        Task<bool> UpdateUserCharacters(long id, List<UserCharacter> list);
        Task<bool> DeleteUserSpareParts(List<UserSparePart> list);
        Task<bool> UpdateUserSpareParts(long id, List<UserSparePart> list);
        Task<bool> InsertUserStamina(long id, int stamina);
        Task<bool> InsertUserExperiences(long id, UserAttribute item);
        Task<bool> UpdateUserExperiences(long id, UserAttribute item);
        Task<bool> UpdateUserSOR(User item, decimal sor);
        Task<bool> UpdateUserESOR(User item, decimal esor);
        Task<bool> InsertUserSOR(User user, decimal amount);
        Task<bool> InsertUserESOR(User user, decimal amount);
        bool InsertUserLoginHistory(long id, Guid sessionId);
        Task<bool> UpdateUserLoginHistory(long id);
        Task<User> GetAdminUserByCredentials(string username, string password);
        Task<User> GetLatestUserLoginHistory(long id, Guid sessionId);
        Task<List<UserCharacter>> GetUserCharacters();
        Task<List<UserSparePart>> GetUserSpareParts();
        Task<List<GameMode>> GetGames();
        Task<List<GameSparePart>> GetGameSpareParts();
        Task<GameSparePart> GetGameSparePartBySparePartId(int gameSparePartId);
        Task<GameCharacter> GetGameCharacterByNftAddress(string nftAddress);
        Task<GameSparePart> GetGameSparePartByNftAddress(string nftAddress);
        Task<UserCharacter> GetUserCharacterByNftAddress(string nftAddress);
        Task<UserSparePart> GetUserGameSparePartByNftAddress(string nftAddress);
        Task<List<GameCoinRule>> GetGameCoins();
        Task<List<GameCoinRule>> GetGameCoinsByMode(string type);
        Task<List<GameItemRule>> GetGameItems();
        Task<List<GameModeRule>> GetGameModes();
        Task<List<GameReward>> GetGameRewards();
        Task<List<GameReward>> GetGameRewardsByMode(string type);
        Task<long> GetMatchCountByMode(string type, long? userId = null);
        Task<List<GameMatchDetail>> GetMatchDetailListByModeAndMatchId(string type, long id);
        Task<List<GameMatchDetail>> GetMatchDetailListByModeAndUniqueId(string type, string uniqueId);
        Task<GameMatch> GetMatchDetailsByModeAndSkipX(string type, int number, long? userId = null);
        Task<List<User>> GetLeaderboardByTopX(int number);
        Task<GameMode> GetGameModeByType(string type);
        Task<long> InsertMatchIdByGameModeId(int gameModeId);
        Task<long> InsertMatchIdByGameModeIdAndUniqueId(int gameModeId, string uniqueId);
        Task<GameMatch> GetMatchDetailsByModeAndId(string type, long id, bool bypass = false);
        Task<GameMatch> GetMatchDetailsByModeAndUniqueId(string type, string uniqueId, bool bypass = false);
        Task<bool> InsertMatchDetails(List<SingleGameMatchDetailModelRequest> data, long gameMatchId);
        Task<bool> InsertSingleMatchDetails(SingleGameMatchDetailModelRequest data, long gameMatchId);
        Task<bool> UpdateUserRewards(List<SingleGameMatchDetailModelRequest> items, List<GameReward> rewards);
        Task<bool> UpdateSingleUserRewards(SingleGameMatchDetailModelRequest items, List<GameReward> rewards);
        Task<bool> UpdateGameSparePart(GameSparePart item, GameSparePartAttributeModel data);
        Task<bool> UpdateGameCoinsRules(List<GameCoinRule> items, List<GameCoinRuleModel> data);
        Task<bool> UpdateGameRewardRules(List<GameReward> items, List<GameRewardModel> data);
        Task<NftLoginUserModelResponse> LoginNftUser(string username, string password);
        Task<NftLoginUserModelResponse> GetNftUser(string nftAddress);
        Task<NftWithdrawalModelResponse> WithdrawNftCoins(string userNftAdress, string type, decimal amount);
    }
}

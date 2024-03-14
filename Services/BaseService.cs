using Microsoft.EntityFrameworkCore;
using Newtonsoft.Json;
using SonicAPI.Interfaces;
using SonicAPI.Models;
using SonicAPI.Models.DataModels;
using SonicAPI.Models.DbSets;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Net.Http;
using System.Net.Http.Headers;
using System.Text;
using System.Text.Json;
using System.Threading.Tasks;

namespace SonicAPI.Services
{
    public class BaseService : IBaseService
    {
        private SonicContext context;
        private IBaseClient baseClient;

        public BaseService(SonicContext context, IBaseClient baseClient)
        {
            this.context = context;
            this.baseClient = baseClient;
        }

        public async Task<User> GetUserByUsername(string username)
        {
            var item = await this.context.Users
                .Where(i => i.Username == username).FirstOrDefaultAsync().ConfigureAwait(false);

            if (item != null)
            {
                var attributes = await this.context.UserAttributes.AsNoTracking().Where(i => i.UserId == item.UserId).FirstOrDefaultAsync().ConfigureAwait(false);
                item.Attributes = attributes;

                var stamina = await this.context.UserStamina.Where(i => i.UserId == item.UserId).ToListAsync().ConfigureAwait(false);
                item.Stamina = stamina;

                var coins = await this.context.UserCoins.Include(b => b.GameCoin).AsNoTracking().Where(i => i.UserId == item.UserId).ToListAsync().ConfigureAwait(false);
                item.Coins = coins;

                var characters = await this.context.UserCharacters.Include(b => b.GameCharacter).AsNoTracking().Where(i => i.UserId == item.UserId).ToListAsync().ConfigureAwait(false);
                item.Characters = characters;

                var spareParts = await this.context.UserSpareParts.Include(b => b.GameSparePart).AsNoTracking().Where(i => i.UserId == item.UserId).ToListAsync().ConfigureAwait(false);
                item.SpareParts = spareParts;
            }

            item = await RefreshStamina(item).ConfigureAwait(false);

            return item;
        }

        public async Task<User> GetUserByNftUserId(string nftUserId)
        {
            var item = await this.context.Users
                .Where(i => i.NftUserId == nftUserId).FirstOrDefaultAsync().ConfigureAwait(false);

            if (item != null)
            {
                var attributes = await this.context.UserAttributes.AsNoTracking().Where(i => i.UserId == item.UserId).FirstOrDefaultAsync().ConfigureAwait(false);
                item.Attributes = attributes;

                var stamina = await this.context.UserStamina.Where(i => i.UserId == item.UserId).ToListAsync().ConfigureAwait(false);
                item.Stamina = stamina;

                var coins = await this.context.UserCoins.Include(b => b.GameCoin).AsNoTracking().Where(i => i.UserId == item.UserId).ToListAsync().ConfigureAwait(false);
                item.Coins = coins;

                var characters = await this.context.UserCharacters.Include(b => b.GameCharacter).AsNoTracking().Where(i => i.UserId == item.UserId).ToListAsync().ConfigureAwait(false);
                item.Characters = characters;

                var spareParts = await this.context.UserSpareParts.Include(b => b.GameSparePart).AsNoTracking().Where(i => i.UserId == item.UserId).ToListAsync().ConfigureAwait(false);
                item.SpareParts = spareParts;
            }

            item = await RefreshStamina(item).ConfigureAwait(false);

            return item;
        }

        public async Task<User> GetUserByNftAddress(string nftAddress)
        {
            var item = await this.context.Users
                .Where(i => i.NftAddress == nftAddress).FirstOrDefaultAsync().ConfigureAwait(false);

            if (item != null)
            {
                var attributes = await this.context.UserAttributes.AsNoTracking().Where(i => i.UserId == item.UserId).FirstOrDefaultAsync().ConfigureAwait(false);
                item.Attributes = attributes;

                var stamina = await this.context.UserStamina.Where(i => i.UserId == item.UserId).ToListAsync().ConfigureAwait(false);
                item.Stamina = stamina;

                var coins = await this.context.UserCoins.Include(b => b.GameCoin).AsNoTracking().Where(i => i.UserId == item.UserId).ToListAsync().ConfigureAwait(false);
                item.Coins = coins;

                var characters = await this.context.UserCharacters.Include(b => b.GameCharacter).AsNoTracking().Where(i => i.UserId == item.UserId).ToListAsync().ConfigureAwait(false);
                item.Characters = characters;

                var spareParts = await this.context.UserSpareParts.Include(b => b.GameSparePart).AsNoTracking().Where(i => i.UserId == item.UserId).ToListAsync().ConfigureAwait(false);
                item.SpareParts = spareParts;
            }

            item = await RefreshStamina(item).ConfigureAwait(false);

            return item;
        }

        public async Task<User> GetUserByNftAddressAsNoTracking(string nftAddress)
        {
            var item = await this.context.Users.AsNoTracking()
                .Where(i => i.NftAddress == nftAddress).FirstOrDefaultAsync().ConfigureAwait(false);

            if (item != null)
            {
                var attributes = await this.context.UserAttributes.AsNoTracking().Where(i => i.UserId == item.UserId).FirstOrDefaultAsync().ConfigureAwait(false);
                item.Attributes = attributes;

                var stamina = await this.context.UserStamina.AsNoTracking().Where(i => i.UserId == item.UserId).ToListAsync().ConfigureAwait(false);
                item.Stamina = stamina;

                var coins = await this.context.UserCoins.AsNoTracking().Include(b => b.GameCoin).Where(i => i.UserId == item.UserId).ToListAsync().ConfigureAwait(false);
                item.Coins = coins;

                var characters = await this.context.UserCharacters.AsNoTracking().Include(b => b.GameCharacter).Where(i => i.UserId == item.UserId).ToListAsync().ConfigureAwait(false);
                item.Characters = characters;

                var spareParts = await this.context.UserSpareParts.AsNoTracking().Include(b => b.GameSparePart).Where(i => i.UserId == item.UserId).ToListAsync().ConfigureAwait(false);
                item.SpareParts = spareParts;
            }

            item = await RefreshStamina(item).ConfigureAwait(false);

            return item;
        }

        public async Task<User> GetUserAsNoTracking(long id)
        {
            var item = await this.context.Users.AsNoTracking()
                .Where(i => i.UserId == id).FirstOrDefaultAsync().ConfigureAwait(false);

            if (item != null)
            {
                var attributes = await this.context.UserAttributes.AsNoTracking().Where(i => i.UserId == item.UserId).FirstOrDefaultAsync().ConfigureAwait(false);
                item.Attributes = attributes;

                var stamina = await this.context.UserStamina.AsNoTracking().Where(i => i.UserId == item.UserId).ToListAsync().ConfigureAwait(false);
                item.Stamina = stamina;

                var coins = await this.context.UserCoins.AsNoTracking().Include(b => b.GameCoin).Where(i => i.UserId == item.UserId).ToListAsync().ConfigureAwait(false);
                item.Coins = coins;

                var characters = await this.context.UserCharacters.AsNoTracking().Include(b => b.GameCharacter).Where(i => i.UserId == item.UserId).ToListAsync().ConfigureAwait(false);
                item.Characters = characters;

                var spareParts = await this.context.UserSpareParts.AsNoTracking().Include(b => b.GameSparePart).Where(i => i.UserId == item.UserId).ToListAsync().ConfigureAwait(false);
                item.SpareParts = spareParts;
            }

            item = await RefreshStamina(item).ConfigureAwait(false);

            return item;
        }

        public async Task<User> GetUser(long id)
        {
            var item = await this.context.Users
                .Where(i => i.UserId == id).FirstOrDefaultAsync().ConfigureAwait(false);

            if (item != null)
            {
                var attributes = await this.context.UserAttributes.AsNoTracking().Where(i => i.UserId == item.UserId).FirstOrDefaultAsync().ConfigureAwait(false);
                item.Attributes = attributes;

                var stamina = await this.context.UserStamina.Where(i => i.UserId == item.UserId).ToListAsync().ConfigureAwait(false);
                item.Stamina = stamina;

                var coins = await this.context.UserCoins.Include(b => b.GameCoin).AsNoTracking().Where(i => i.UserId == item.UserId).ToListAsync().ConfigureAwait(false);
                item.Coins = coins;

                var characters = await this.context.UserCharacters.Include(b => b.GameCharacter).AsNoTracking().Where(i => i.UserId == item.UserId).ToListAsync().ConfigureAwait(false);
                item.Characters = characters;

                var spareParts = await this.context.UserSpareParts.Include(b => b.GameSparePart).AsNoTracking().Where(i => i.UserId == item.UserId).ToListAsync().ConfigureAwait(false);
                item.SpareParts = spareParts;
            }

            item = await RefreshStamina(item).ConfigureAwait(false);

            return item;
        }

        public async Task<bool> InsertUser(string userNftAddress, string userNftId, string username, string email)
        {
            try
            {
                var coins = await GetGameCoins().ConfigureAwait(false);
                var itemCoins = new List<UserCoin>();

                var sor = coins.Where(i => i.GameCoin.Type == "SOR").FirstOrDefault();

                if (sor != null)
                {
                    itemCoins.Add(new UserCoin
                    {
                        GameCoinId = sor.GameCoinId,
                        Amount = 0
                    });
                }

                var esor = coins.Where(i => i.GameCoin.Type == "ESOR").FirstOrDefault();

                if (esor != null)
                {
                    itemCoins.Add(new UserCoin
                    {
                        GameCoinId = esor.GameCoinId,
                        Amount = 0
                    });
                }

                var characters = await GetGameCharacters().ConfigureAwait(false);
                var itemCharacters = new List<UserCharacter>();

                var defaultCharacters = characters.Where(i => string.IsNullOrEmpty(i.NftAddress)).ToList();

                if (defaultCharacters != null &&
                    defaultCharacters.Count > 0)
                {
                    foreach (var defaults in defaultCharacters)
                    {
                        itemCharacters.Add(new UserCharacter
                        {
                            GameCharacterId = defaults.GameCharacterId,
                            IsOccupied = false
                        });
                    }
                }

                var item = new User
                {
                    Username = username,
                    Email = email,
                    NftAddress = userNftAddress,
                    NftUserId = userNftId,
                    Attributes = new UserAttribute
                    {
                        Levels = 1,
                        Experiences = 0,
                        ElitePoints = 0,
                        Trophies = 0
                    },
                    Stamina = new List<UserStamina>
                    {
                        new UserStamina
                        {
                            Amount = 24
                        }
                    },
                    Coins = itemCoins,
                    Characters = itemCharacters
                };

                await this.context.AddAsync(item).ConfigureAwait(false);
                await this.context.SaveChangesAsync().ConfigureAwait(false);

                return true;
            }
            catch (Exception ex)
            {
                return false;
            }
        }

        private async Task<User> RefreshStamina(User item)
        {
            if (item != null &&
                item.Stamina != null &&
                item.Stamina.Count > 0)
            {
                //only take the positive stamina value for purpose of stamina increment.
                var staminaList = item.Stamina.Where(i => i.Amount >= 0).OrderByDescending(i => i.DateCreated);
                var lastStaminaList = staminaList.FirstOrDefault();

                var date1 = new DateTime(lastStaminaList.DateCreated.Year, lastStaminaList.DateCreated.Month, lastStaminaList.DateCreated.Day, lastStaminaList.DateCreated.Hour, 0, 0);
                var date2 = DateTime.UtcNow;
                var ts = Math.Floor((date2 - date1).TotalHours);

                if (ts > 0)
                {
                    await InsertUserStamina(item.UserId, (int)ts).ConfigureAwait(false);
                }
            }

            return item;
        }

        public async Task<bool> UpdateUserCharactersIsOccupied(List<UserCharacter> list)
        {
            try
            {
                foreach (var li in list)
                {
                    li.DateModified = DateTime.UtcNow;
                }

                this.context.UpdateRange(list);
                await this.context.SaveChangesAsync().ConfigureAwait(false);

                return true;
            }
            catch (Exception)
            {
                return false;
            }
        }

        public async Task<bool> UpdateUserSparePartsIsOccupied(List<UserSparePart> list)
        {
            try
            {
                foreach (var li in list)
                {
                    li.DateModified = DateTime.UtcNow;
                }

                this.context.UpdateRange(list);
                await this.context.SaveChangesAsync().ConfigureAwait(false);

                return true;
            }
            catch (Exception)
            {
                return false;
            }
        }

        public async Task<bool> InsertUserCharacter(User item, GameCharacter nftItem)
        {
            try
            {
                var data = item.Characters.Where(i => i.GameCharacterId == nftItem.GameCharacterId).FirstOrDefault();

                if (data == null)
                {
                    var newItem = new UserCharacter
                    {
                        UserId = item.UserId,
                        GameCharacterId = nftItem.GameCharacterId,
                        IsOccupied = false
                    };

                    await this.context.AddAsync(newItem).ConfigureAwait(false);
                    await this.context.SaveChangesAsync().ConfigureAwait(false);

                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch (Exception)
            {
                return false;
            }
        }

        public async Task<bool> InsertUserCharacters(long id, List<string> list)
        {
            try
            {
                var data = new List<UserCharacter>();

                foreach (var li in list)
                {
                    var d = await this.context.GameCharacters.AsNoTracking().Where(i => i.NftAddress == li).FirstOrDefaultAsync().ConfigureAwait(false);

                    if (d != null)
                    {
                        data.Add(new UserCharacter
                        {
                            UserId = id,
                            GameCharacterId = d.GameCharacterId,
                            IsOccupied = false
                        });
                    }
                }

                if (data != null &&
                    data.Count > 0)
                {
                    await this.context.AddRangeAsync(data).ConfigureAwait(false);
                    await this.context.SaveChangesAsync().ConfigureAwait(false);

                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch (Exception ex)
            {
                return false;
            }
        }

        public async Task<bool> InsertUserSparePart(User item, GameSparePart nftItem)
        {
            try
            {
                var data = item.SpareParts.Where(i => i.GameSparePartId == nftItem.GameSparePartId).FirstOrDefault();

                if (data == null)
                {
                    var newItem = new UserSparePart
                    {
                        UserId = item.UserId,
                        GameSparePartId = nftItem.GameSparePartId,
                        IsOccupied = false
                    };

                    await this.context.AddAsync(newItem).ConfigureAwait(false);
                    await this.context.SaveChangesAsync().ConfigureAwait(false);

                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch (Exception)
            {
                return false;
            }
        }

        public async Task<bool> InsertUserSpareParts(long id, List<string> list)
        {
            try
            {
                var data = new List<UserSparePart>();

                foreach (var li in list)
                {
                    var d = await this.context.GameSpareParts.AsNoTracking().Where(i => i.NftAddress == li).FirstOrDefaultAsync().ConfigureAwait(false);

                    if (d != null)
                    {
                        data.Add(new UserSparePart
                        {
                            UserId = id,
                            GameSparePartId = d.GameSparePartId,
                            IsOccupied = false
                        });
                    }
                }

                if (data != null &&
                    data.Count > 0)
                {
                    await this.context.AddRangeAsync(data).ConfigureAwait(false);
                    await this.context.SaveChangesAsync().ConfigureAwait(false);

                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch (Exception)
            {
                return false;
            }
        }

        public async Task<bool> UpdateUserCharacter(User item, UserCharacter nftItem)
        {
            try
            {
                var data = item.Characters.Where(i => i.GameCharacterId == nftItem.GameCharacterId).FirstOrDefault();

                if (data == null)
                {
                    nftItem.UserId = item.UserId;
                    nftItem.DateModified = DateTime.UtcNow;

                    this.context.Update(nftItem);
                    await this.context.SaveChangesAsync().ConfigureAwait(false);

                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch (Exception)
            {
                return false;
            }
        }

        public async Task<bool> DeleteUserCharacters(List<UserCharacter> list)
        {
            try
            {
                var data = new List<UserCharacter>();

                foreach (var li in list)
                {
                    var d = await this.context.UserCharacters.AsNoTracking().Include(b => b.GameCharacter).Where(i => i.UserCharacterId == li.UserCharacterId).FirstOrDefaultAsync().ConfigureAwait(false);

                    if (d != null)
                    {
                        data.Add(d);
                    }
                }

                if (data != null &&
                    data.Count > 0)
                {
                    this.context.RemoveRange(data);
                    await this.context.SaveChangesAsync().ConfigureAwait(false);

                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch (Exception)
            {
                return false;
            }
        }

        public async Task<bool> UpdateUserCharacters(long id, List<UserCharacter> list)
        {
            try
            {
                foreach (var li in list)
                {
                    li.UserId = id;
                    li.DateModified = DateTime.UtcNow;
                }

                this.context.UpdateRange(list);
                await this.context.SaveChangesAsync().ConfigureAwait(false);

                return true;
            }
            catch (Exception)
            {
                return false;
            }
        }

        public async Task<bool> DeleteUserSpareParts(List<UserSparePart> list)
        {
            try
            {
                var data = new List<UserSparePart>();

                foreach (var li in list)
                {
                    var d = await this.context.UserSpareParts.AsNoTracking().Include(b => b.GameSparePart).Where(i => i.UserSparePartId == li.UserSparePartId).FirstOrDefaultAsync().ConfigureAwait(false);

                    if (d != null)
                    {
                        data.Add(d);
                    }
                }

                if (data != null &&
                    data.Count > 0)
                {
                    this.context.RemoveRange(data);
                    await this.context.SaveChangesAsync().ConfigureAwait(false);

                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch (Exception)
            {
                return false;
            }
        }

        public async Task<bool> UpdateUserSpareParts(long id, List<UserSparePart> list)
        {
            try
            {
                foreach (var li in list)
                {
                    li.UserId = id;
                    li.DateModified = DateTime.UtcNow;
                }

                this.context.UpdateRange(list);
                await this.context.SaveChangesAsync().ConfigureAwait(false);

                return true;
            }
            catch (Exception)
            {
                return false;
            }
        }

        public async Task<bool> UpdateUserSparePart(User item, UserSparePart nftItem)
        {
            try
            {
                var data = item.SpareParts.Where(i => i.GameSparePartId == nftItem.GameSparePartId).FirstOrDefault();

                if (data == null)
                {
                    nftItem.UserId = item.UserId;
                    nftItem.DateModified = DateTime.UtcNow;

                    this.context.Update(nftItem);
                    await this.context.SaveChangesAsync().ConfigureAwait(false);

                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch (Exception)
            {
                return false;
            }
        }

        public async Task<bool> InsertUserStamina(long id, int stamina)
        {
            try
            {
                var item = new UserStamina
                {
                    UserId = id,
                    Amount = stamina
                };

                await this.context.AddAsync(item).ConfigureAwait(false);
                await this.context.SaveChangesAsync().ConfigureAwait(false);

                return true;
            }
            catch (Exception)
            {
                return false;
            }
        }

        public async Task<bool> InsertUserExperiences(long id, UserAttribute item)
        {
            try
            {
                await this.context.AddAsync(item).ConfigureAwait(false);
                await this.context.SaveChangesAsync().ConfigureAwait(false);

                return true;
            }
            catch (Exception)
            {
                return false;
            }
        }

        public async Task<bool> UpdateUserExperiences(long id, UserAttribute item)
        {
            try
            {
                item.DateModified = DateTime.UtcNow;

                this.context.Update(item);
                await this.context.SaveChangesAsync().ConfigureAwait(false);

                return true;
            }
            catch (Exception)
            {
                return false;
            }
        }

        public async Task<bool> UpdateUserSOR(User item, decimal sor)
        {
            try
            {
                var data = item.Coins.Where(i => i.GameCoin.Type == "SOR").FirstOrDefault();

                if (data != null)
                {
                    data.Amount = sor;
                    data.DateModified = DateTime.UtcNow;

                    this.context.Update(data);
                    await this.context.SaveChangesAsync().ConfigureAwait(false);

                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch (Exception)
            {
                return false;
            }
        }

        public async Task<bool> UpdateUserESOR(User item, decimal esor)
        {
            try
            {
                var data = item.Coins.Where(i => i.GameCoin.Type == "ESOR").FirstOrDefault();

                if (data != null)
                {
                    data.Amount = esor;
                    data.DateModified = DateTime.UtcNow;

                    this.context.Update(data);
                    await this.context.SaveChangesAsync().ConfigureAwait(false);

                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch (Exception)
            {
                return false;
            }
        }

        public async Task<bool> InsertUserSOR(User user, decimal amount)
        {
            try
            {
                var coins = await GetGameCoins().ConfigureAwait(false);
                var sor = coins.Where(i => i.GameCoin.Type == "SOR").FirstOrDefault();
                var data = new UserCoin
                {
                    UserId = user.UserId,
                    GameCoinId = sor.GameCoinId,
                    Amount = amount
                };

                await this.context.AddAsync(data).ConfigureAwait(false);
                await this.context.SaveChangesAsync().ConfigureAwait(false);

                return true;
            }
            catch (Exception)
            {
                return false;
            }
        }

        public async Task<bool> InsertUserESOR(User user, decimal amount)
        {
            try
            {
                var coins = await GetGameCoins().ConfigureAwait(false);
                var sor = coins.Where(i => i.GameCoin.Type == "ESOR").FirstOrDefault();
                var data = new UserCoin
                {
                    UserId = user.UserId,
                    GameCoinId = sor.GameCoinId,
                    Amount = amount
                };

                await this.context.AddAsync(data).ConfigureAwait(false);
                await this.context.SaveChangesAsync().ConfigureAwait(false);

                return true;
            }
            catch (Exception)
            {
                return false;
            }
        }

        public bool InsertUserLoginHistory(long id, Guid sessionId)
        {
            var contextOptions = new DbContextOptionsBuilder<SonicContext>().UseSqlServer(Startup.StaticConfig["Database:sonicDb"]).Options;

            using (var existingContext = new SonicContext(contextOptions))
            {
                try
                {
                    var item = new UserLoginHistory
                    {
                        UserId = id,
                        SessionId = sessionId
                    };

                    existingContext.Add(item);
                    existingContext.SaveChanges();

                    return true;
                }
                catch (Exception ex)
                {
                    return false;
                }
            }
        }

        public async Task<bool> UpdateUserLoginHistory(long id)
        {
            try
            {
                var item = await this.context.UserLoginHistory
                    .Include(i => i.User)
                    .Where(i => i.UserId == id)
                    .OrderByDescending(i => i.DateCreated).FirstOrDefaultAsync().ConfigureAwait(false);

                if (item != null)
                {
                    item.SessionId = Guid.Empty;
                    item.DateModified = DateTime.UtcNow;

                    this.context.Update(item);
                    await this.context.SaveChangesAsync().ConfigureAwait(false);

                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch (Exception)
            {
                return false;
            }
        }

        public async Task<User> GetAdminUserByCredentials(string username, string password)
        {
            var item = await this.context.Admins
                .Where(i => i.Username == username && i.Password == password).FirstOrDefaultAsync().ConfigureAwait(false);

            User model = null;

            if (item != null)
            {
                model = new User
                {
                    Username = item.Username
                };
            }

            return model;
        }

        public async Task<User> GetLatestUserLoginHistory(long id, Guid sessionId)
        {
            var item = await this.context.UserLoginHistory
                .Include(i => i.User)
                .Where(i => i.UserId == id)
                .OrderByDescending(i => i.DateCreated).FirstOrDefaultAsync().ConfigureAwait(false);

            User model = null;

            if (item != null &&
                item.SessionId != sessionId)
            {
                item = null;
            }
            else if (item != null)
            {
                model = item.User;
            }

            return model;
        }

        public async Task<List<UserCharacter>> GetUserCharacters()
        {
            var items = new List<UserCharacter>();

            items = await this.context.UserCharacters.Include(b => b.GameCharacter).AsNoTracking()
            .ToListAsync().ConfigureAwait(false);

            return items;
        }

        public async Task<List<UserSparePart>> GetUserSpareParts()
        {
            var items = new List<UserSparePart>();

            items = await this.context.UserSpareParts.Include(b => b.GameSparePart).AsNoTracking()
            .ToListAsync().ConfigureAwait(false);

            return items;
        }

        public async Task<List<GameMode>> GetGames()
        {
            var items = new List<GameMode>();

            items = await this.context.GameModes
            .Include(i => i.Rules)
            .Include(i => i.CoinRules).ThenInclude(b => b.GameCoin)
            .Include(i => i.ItemRules).ThenInclude(b => b.GameItem)
            .Include(i => i.Rewards).ThenInclude(b => b.Attributes)
            .ToListAsync().ConfigureAwait(false);

            return items;
        }

        public async Task<List<GameSparePart>> GetGameSpareParts()
        {
            var items = new List<GameSparePart>();

            items = await this.context.GameSpareParts
            .Include(i => i.Attributes)
            .ToListAsync().ConfigureAwait(false);

            return items;
        }

        public async Task<GameSparePart> GetGameSparePartBySparePartId(int gameSparePartId)
        {
            var item = await this.context.GameSpareParts
            .Include(i => i.Attributes)
            .Where(i => i.GameSparePartId == gameSparePartId)
            .FirstOrDefaultAsync().ConfigureAwait(false);

            return item;
        }

        public async Task<GameCharacter> GetGameCharacterByNftAddress(string nftAddress)
        {
            var item = await this.context.GameCharacters
            .Where(i => i.NftAddress == nftAddress)
            .FirstOrDefaultAsync().ConfigureAwait(false);

            return item;
        }

        public async Task<GameSparePart> GetGameSparePartByNftAddress(string nftAddress)
        {
            var item = await this.context.GameSpareParts
            .Include(i => i.Attributes)
            .Where(i => i.NftAddress == nftAddress)
            .FirstOrDefaultAsync().ConfigureAwait(false);

            return item;
        }

        public async Task<UserCharacter> GetUserCharacterByNftAddress(string nftAddress)
        {
            var item = await this.context.UserCharacters
            .Include(i => i.GameCharacter)
            .Where(i => i.GameCharacter.NftAddress == nftAddress)
            .FirstOrDefaultAsync().ConfigureAwait(false);

            return item;
        }

        public async Task<UserSparePart> GetUserGameSparePartByNftAddress(string nftAddress)
        {
            var item = await this.context.UserSpareParts
            .Include(i => i.GameSparePart)
            .Where(i => i.GameSparePart.NftAddress == nftAddress)
            .FirstOrDefaultAsync().ConfigureAwait(false);

            return item;
        }

        public async Task<List<GameCoinRule>> GetGameCoins()
        {
            var items = new List<GameCoinRule>();

            items = await this.context.GameCoinRules
            .Include(i => i.GameCoin)
            .Include(i => i.GameMode)
            .ToListAsync().ConfigureAwait(false);

            return items;
        }

        public async Task<List<GameCoinRule>> GetGameCoinsByMode(string type)
        {
            var items = new List<GameCoinRule>();

            items = await this.context.GameCoinRules
            .Include(i => i.GameCoin)
            .Include(i => i.GameMode)
            .Where(i => i.GameMode.Type == type)
            .ToListAsync().ConfigureAwait(false);

            return items;
        }

        public async Task<List<GameItemRule>> GetGameItems()
        {
            var items = new List<GameItemRule>();

            items = await this.context.GameItemRules
            .Include(i => i.GameItem)
            .Include(i => i.GameMode)
            .ToListAsync().ConfigureAwait(false);

            return items;
        }

        public async Task<List<GameModeRule>> GetGameModes()
        {
            var items = new List<GameModeRule>();

            items = await this.context.GameModeRules
            .Include(i => i.GameMode)
            .ToListAsync().ConfigureAwait(false);

            return items;
        }

        public async Task<List<GameCharacter>> GetGameCharacters()
        {
            var items = new List<GameCharacter>();

            items = await this.context.GameCharacters
            .ToListAsync().ConfigureAwait(false);

            return items;
        }

        public async Task<List<GameReward>> GetGameRewards()
        {
            var items = new List<GameReward>();

            items = await this.context.GameRewards
            .Include(i => i.GameMode)
            .Include(i => i.Attributes).ThenInclude(b => b.GameCoin)
            .ToListAsync().ConfigureAwait(false);

            return items;
        }

        public async Task<List<GameReward>> GetGameRewardsByMode(string type)
        {
            var items = new List<GameReward>();

            items = await this.context.GameRewards
            .Include(i => i.GameMode)
            .Include(i => i.Attributes).ThenInclude(b => b.GameCoin)
            .Where(i => i.GameMode.Type == type)
            .ToListAsync().ConfigureAwait(false);

            return items;
        }

        public async Task<long> GetMatchCountByMode(string type, long? userId)
        {
            long item = 0;

            if (userId != null)
            {
                item = await this.context.GameMatchDetails
                    .Include(i => i.User)
                    .Include(i => i.GameMatch).ThenInclude(i => i.GameMode)
                    .Where(i => i.GameMatch.GameMode.Type == type && i.UserId == userId)
                    .GroupBy(n => n.GameMatch.GameMatchId).CountAsync().ConfigureAwait(false);
            }
            else
            {
                item = await this.context.GameMatchDetails
                    .Include(i => i.GameMatch).ThenInclude(i => i.GameMode)
                    .Where(i => i.GameMatch.GameMode.Type == type)
                    .GroupBy(n => n.GameMatch.GameMatchId).CountAsync().ConfigureAwait(false);
            }

            return item;
        }

        public async Task<List<GameMatchDetail>> GetMatchDetailListByModeAndMatchId(string type, long id)
        {
            var items = new List<GameMatchDetail>();

            items = await this.context.GameMatchDetails
                .Include(i => i.User)
                .Include(i => i.GameMatch).ThenInclude(i => i.GameMode)
                .OrderBy(b => b.PlayerRanking)
                .Where(i => i.GameMatchId == id && i.GameMatch.GameMode.Type == type).ToListAsync().ConfigureAwait(false);

            return items;
        }

        public async Task<List<GameMatchDetail>> GetMatchDetailListByModeAndUniqueId(string type, string uniqueId)
        {
            var items = new List<GameMatchDetail>();

            items = await this.context.GameMatchDetails
                .Include(i => i.User)
                .Include(i => i.GameMatch).ThenInclude(i => i.GameMode)
                .OrderBy(b => b.PlayerRanking)
                .Where(i => i.GameMatch.GameUniqueId == uniqueId && i.GameMatch.GameMode.Type == type).ToListAsync().ConfigureAwait(false);

            return items;
        }

        public async Task<GameMatch> GetMatchDetailsByModeAndSkipX(string type, int number, long? userId)
        {
            GameMatch item = null;

            if (number > 0) --number;

            if (userId != null)
            {
                var tempMatchId = await this.context.GameMatches
                    .Include(i => i.Details).ThenInclude(i => i.User)
                    .Include(i => i.GameMode)
                    .Where(i => i.GameMode.Type == type && i.Details.Where(i => i.UserId == userId).Any()).OrderBy(b => b.GameMatchId).Skip(number).Select(c => c.GameMatchId).FirstOrDefaultAsync().ConfigureAwait(false);

                if (tempMatchId != 0)
                {
                    item = await this.context.GameMatches
                        .Include(i => i.Details).ThenInclude(i => i.User)
                        .Include(i => i.GameMode)
                        .Where(i => i.GameMatchId == tempMatchId).FirstOrDefaultAsync().ConfigureAwait(false);
                }
            }
            else
            {
                item = await this.context.GameMatches
                    .Include(i => i.Details).ThenInclude(i => i.User)
                    .Include(i => i.GameMode)
                    .Where(i => i.GameMode.Type == type).OrderBy(b => b.GameMatchId).Skip(number).FirstOrDefaultAsync().ConfigureAwait(false);
            }

            if (item != null &&
                item.Details != null &&
                item.Details.Count > 0)
            {
                item.Details = item.Details.OrderBy(i => i.PlayerRanking).ToList();
            }

            return item;
        }

        public async Task<List<User>> GetLeaderboardByTopX(int number)
        {
            var items = new List<User>();

            items = await this.context.Users
                .Include(i => i.Attributes)
                .OrderByDescending(b => b.Attributes.ElitePoints)
                .Take(number).ToListAsync().ConfigureAwait(false);

            return items;
        }
        
        public async Task<GameMode> GetGameModeByType(string type)
        {
            GameMode item = null;

            item = await this.context.GameModes
                .Where(i => i.Type == type).FirstOrDefaultAsync().ConfigureAwait(false);

            return item;
        }

        public async Task<long> InsertMatchIdByGameModeId(int gameModeId)
        {
            var item = new GameMatch
            {
                GameModeId = gameModeId
            };

            await this.context.AddAsync(item).ConfigureAwait(false);
            await this.context.SaveChangesAsync().ConfigureAwait(false);

            return item.GameMatchId;
        }

        public async Task<long> InsertMatchIdByGameModeIdAndUniqueId(int gameModeId, string gameUniqueId)
        {
            var item = new GameMatch
            {
                GameModeId = gameModeId,
                GameUniqueId = gameUniqueId
            };

            var exists = await this.context.GameMatches
                        .Include(i => i.GameMode)
                        .Include(b => b.Details)
                        .Where(i => i.GameUniqueId == gameUniqueId && i.GameModeId == gameModeId).FirstOrDefaultAsync().ConfigureAwait(false);

            if (exists != null &&
                (exists.Details == null || exists.Details.Count == 0))
            {
                item.GameMatchId = exists.GameMatchId;
            }
            else
            {
                await this.context.AddAsync(item).ConfigureAwait(false);
                await this.context.SaveChangesAsync().ConfigureAwait(false);
            }

            return item.GameMatchId;
        }

        public async Task<GameMatch> GetMatchDetailsByModeAndId(string type, long id, bool bypass = false)
        {
            var item = await this.context.GameMatches
                    .Include(i => i.GameMode)
                    .Include(b => b.Details)
                    .Where(i => i.GameMatchId == id && i.GameMode.Type == type).FirstOrDefaultAsync().ConfigureAwait(false);

            if (item != null &&
                ((item.Details == null || item.Details.Count == 0) || (bypass)))
            {
                //DO NOTHING
            }
            else
            {
                item = null;
            }

            return item;
        }

        public async Task<GameMatch> GetMatchDetailsByModeAndUniqueId(string type, string uniqueId, bool bypass = false)
        {
            var item = await this.context.GameMatches
                    .Include(i => i.GameMode)
                    .Include(b => b.Details)
                    .Where(i => i.GameUniqueId == uniqueId && i.GameMode.Type == type).FirstOrDefaultAsync().ConfigureAwait(false);

            if (item != null &&
                ((item.Details == null || item.Details.Count == 0) || (bypass)))
            {
                //DO NOTHING
            }
            else
            {
                item = null;
            }

            return item;
        }

        public async Task<bool> InsertMatchDetails(List<SingleGameMatchDetailModelRequest> data, long gameMatchId)
        {
            try
            {
                if (data != null &&
                    data.Count > 0)
                {
                    var items = new List<GameMatchDetail>();
                    var index = 1;
                    foreach (var item in data)
                    {
                        if (item.UserId != null)
                        {
                            items.Add(new GameMatchDetail
                            {
                                GameMatchId = gameMatchId,
                                PlayerRanking = item.PlayerRanking,
                                UserId = item.UserId,
                                LapTime = item.LapTime
                            });
                        }
                        else
                        {
                            items.Add(new GameMatchDetail
                            {
                                GameMatchId = gameMatchId,
                                PlayerRanking = item.PlayerRanking,
                                UserId = item.UserId,
                                CustomPlayerName = GetCustomPlayerName(index),
                                LapTime = item.LapTime
                            });
                        }

                        index++;
                    }

                    if (items.Count > 0)
                    {
                        await this.context.AddRangeAsync(items).ConfigureAwait(false);
                        await this.context.SaveChangesAsync().ConfigureAwait(false);

                        return true;
                    }
                    else
                    {
                        return false;
                    }
                }
                else
                {
                    return false;
                }
            }
            catch (Exception ex)
            {
                return false;
            }
        }

        public async Task<bool> InsertSingleMatchDetails(SingleGameMatchDetailModelRequest data, long gameMatchId)
        {

            try
            {
                if (data != null)
                {
                    GameMatchDetail item = null;

                    if (data.UserId != null)
                    {
                        item = new GameMatchDetail
                        {
                            GameMatchId = gameMatchId,
                            PlayerRanking = data.PlayerRanking,
                            UserId = data.UserId,
                            LapTime = data.LapTime
                        };
                    }
                    else
                    {
                        Random rnd = new Random();
                        int index = rnd.Next(1, 10); // creates a number between 1 and 10

                        item = new GameMatchDetail
                        {
                            GameMatchId = gameMatchId,
                            PlayerRanking = data.PlayerRanking,
                            UserId = data.UserId,
                            CustomPlayerName = GetCustomPlayerName(index),
                            LapTime = data.LapTime
                        };
                    }

                    await this.context.AddAsync(item).ConfigureAwait(false);
                    await this.context.SaveChangesAsync().ConfigureAwait(false);

                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch (Exception ex)
            {
                return false;
            }
        }

        public async Task<bool> UpdateSingleUserRewards(SingleGameMatchDetailModelRequest item, List<GameReward> rewards)
        {
            using var transaction = this.context.Database.BeginTransaction();

            try
            {
                var flag = true;
                var data = item;
                if (data.UserId != null)
                {
                    var d = await this.context.Users
                        .Include(i => i.Attributes)
                        .Include(i => i.Coins)
                        .FirstOrDefaultAsync(i => i.UserId == data.UserId).ConfigureAwait(false);

                    if (d != null)
                    {
                        var reward = rewards.Where(i => i.PlayerRanking == data.PlayerRanking).FirstOrDefault();

                        if (reward != null)
                        {
                            //NOT REQUIRED TO UPDATE HERE. APP WILL DO THAT.
                            //if (reward.Experiences > 0)
                            //{
                            //    d.Attributes.Experiences += reward.Experiences;
                            //}

                            if (reward.ElitePoints > 0)
                            {
                                d.Attributes.ElitePoints += reward.ElitePoints;
                            }

                            if (reward.Trophies > 0)
                            {
                                d.Attributes.Trophies += reward.Trophies;
                            }

                            //NOT REQUIRED TO UPDATE HERE. APP WILL DO THAT.
                            //if (d.Coins != null &&
                            //    d.Coins.Count > 0)
                            //{
                            //    for (int b = 0; b < d.Coins.Count; b++)
                            //    {
                            //        var userCoin = d.Coins[b];
                            //        var rewardCoin = reward.Attributes.Where(i => i.GameCoinId == userCoin.GameCoinId).FirstOrDefault();
                            //
                            //        if (rewardCoin != null &&
                            //            rewardCoin.Amount > 0)
                            //        {
                            //            userCoin.Amount += rewardCoin.Amount;
                            //            userCoin.DateModified = DateTime.UtcNow;
                            //        }
                            //    }
                            //}

                            d.Attributes.DateModified = DateTime.UtcNow;

                            this.context.Update(d);
                            await this.context.SaveChangesAsync().ConfigureAwait(false);
                        }
                    }
                    else
                    {
                        flag = false;
                    }
                }

                if (flag)
                {
                    // Commit transaction if all commands succeed, transaction will auto-rollback
                    // when disposed if either commands fails
                    await transaction.CommitAsync().ConfigureAwait(false);
                    return true;
                }
                else
                {
                    await transaction.RollbackAsync().ConfigureAwait(false);
                    return false;
                }
            }
            catch (Exception)
            {
                await transaction.RollbackAsync().ConfigureAwait(false);
                return false;
            }
        }

        public async Task<bool> UpdateUserRewards(List<SingleGameMatchDetailModelRequest> items, List<GameReward> rewards)
        {
            using var transaction = this.context.Database.BeginTransaction();

            try
            {
                var flag = true;
                foreach (var data in items)
                {
                    if (data.UserId != null)
                    {
                        var d = await this.context.Users
                            .Include(i => i.Attributes)
                            .Include(i => i.Coins)
                            .FirstOrDefaultAsync(i => i.UserId == data.UserId).ConfigureAwait(false);

                        if (d != null)
                        {
                            var reward = rewards.Where(i => i.PlayerRanking == data.PlayerRanking).FirstOrDefault();

                            if (reward != null)
                            {
                                //NOT REQUIRED TO UPDATE HERE. APP WILL DO THAT.
                                //if (reward.Experiences > 0)
                                //{
                                //    d.Attributes.Experiences += reward.Experiences;
                                //}

                                if (reward.ElitePoints > 0)
                                {
                                    d.Attributes.ElitePoints += reward.ElitePoints;
                                }

                                if (reward.Trophies > 0)
                                {
                                    d.Attributes.Trophies += reward.Trophies;
                                }

                                //NOT REQUIRED TO UPDATE HERE. APP WILL DO THAT.
                                //if (d.Coins != null &&
                                //    d.Coins.Count > 0)
                                //{
                                //    for (int b=0; b < d.Coins.Count; b++)
                                //    {
                                //        var userCoin = d.Coins[b];
                                //        var rewardCoin = reward.Attributes.Where(i => i.GameCoinId == userCoin.GameCoinId).FirstOrDefault();
                                //
                                //        if (rewardCoin != null &&
                                //            rewardCoin.Amount > 0)
                                //        {
                                //            userCoin.Amount += rewardCoin.Amount;
                                //            userCoin.DateModified = DateTime.UtcNow;
                                //        }
                                //    }
                                //}

                                d.Attributes.DateModified = DateTime.UtcNow;

                                this.context.Update(d);
                                await this.context.SaveChangesAsync().ConfigureAwait(false);
                            }
                        }
                        else
                        {
                            flag = false;
                            break;
                        }
                    }
                }

                if (flag)
                {
                    // Commit transaction if all commands succeed, transaction will auto-rollback
                    // when disposed if either commands fails
                    await transaction.CommitAsync().ConfigureAwait(false);
                    return true;
                }
                else
                {
                    await transaction.RollbackAsync().ConfigureAwait(false);
                    return false;
                }
            }
            catch (Exception)
            {
                await transaction.RollbackAsync().ConfigureAwait(false);
                return false;
            }
        }

        public async Task<bool> UpdateGameSparePart(GameSparePart item, GameSparePartAttributeModel data)
        {
            try
            {
                if (item.Attributes != null)
                {
                    item.Attributes.Acceleration = data.Acceleration;
                    item.Attributes.MaximumSpeed = data.MaximumSpeed;
                    item.Attributes.TurboSpeed = data.TurboSpeed;
                    item.Attributes.EnergyAddOnAmount = data.EnergyAddOnAmount;
                    item.Attributes.SterlingAmount = data.SterlingAmount;
                    item.DateModified = DateTime.UtcNow;

                    this.context.Update(item);
                    await this.context.SaveChangesAsync().ConfigureAwait(false);

                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch (Exception)
            {
                return false;
            }
        }

        public async Task<bool> UpdateGameCoinsRules(List<GameCoinRule> items, List<GameCoinRuleModel> data)
        {
            try
            {
                var dt = DateTime.UtcNow;

                foreach (var item in items)
                {
                    var newItem = data.Where(i => i.GameCoin?.Type == item.GameCoin.Type).FirstOrDefault();

                    if (newItem != null)
                    {
                        item.MinimumValue = newItem.MinimumValue;
                        item.MaximumValue = newItem.MaximumValue;
                        item.MinimumCount = newItem.MinimumCount;
                        item.MaximumCount = newItem.MaximumCount;
                        item.Occurences = newItem.Occurences;
                        item.DateModified = dt;
                    }
                }

                this.context.UpdateRange(items);
                await this.context.SaveChangesAsync().ConfigureAwait(false);

                return true;

            }
            catch (Exception)
            {
                return false;
            }
        }

        public async Task<bool> UpdateGameRewardRules(List<GameReward> items, List<GameRewardModel> data)
        {
            try
            {
                var dt = DateTime.UtcNow;

                foreach (var item in items)
                {
                    var newItem = data.Where(i => i.PlayerRanking == item.PlayerRanking).FirstOrDefault();

                    if (newItem != null)
                    {
                        item.PlayerRanking = newItem.PlayerRanking;
                        item.Experiences = newItem.Experiences;
                        item.ElitePoints = newItem.ElitePoints;
                        item.Trophies = newItem.Trophies;
                        item.DateModified = dt;

                        if (item.Attributes != null &&
                            item.Attributes.Count > 0)
                        {
                            foreach (var attr in item.Attributes)
                            {
                                var newAttr = newItem.Attributes?.Where(b => b.GameCoin?.Type == attr.GameCoin.Type).FirstOrDefault();

                                if (newAttr != null)
                                {
                                    attr.Amount = newAttr.Amount;
                                    attr.DateModified = dt;
                                }
                            }
                        }
                    }
                }

                this.context.UpdateRange(items);
                await this.context.SaveChangesAsync().ConfigureAwait(false);

                return true;

            }
            catch (Exception)
            {
                return false;
            }
        }

        public async Task<NftLoginUserModelResponse> LoginNftUser(string username, string password)
        {
            NftLoginUserModelResponse response = null;
            var rawRequest = new LoginUserModelRequest
            {
                Username = username,
                Password = password
            };

            var jsonResponse = await this.baseClient.PostAsync(rawRequest, Startup.StaticConfig["Endpoints:Marketplace:LoginAPI"], Helpers.Extensions.GenerateJwtToken(null, null, Startup.StaticConfig["JWT:Marketplace:Key"])).ConfigureAwait(false);

            if (jsonResponse == null || 
                (jsonResponse.StatusCode != System.Net.HttpStatusCode.OK && jsonResponse.StatusCode != System.Net.HttpStatusCode.NotFound && jsonResponse.StatusCode != System.Net.HttpStatusCode.Unauthorized && jsonResponse.StatusCode != System.Net.HttpStatusCode.UnprocessableEntity))
            {
                response = new NftLoginUserModelResponse
                {
                    Messages = new List<string>
                    {
                        "Internal server error."
                    }
                };
            }
            else if (jsonResponse.StatusCode == System.Net.HttpStatusCode.OK)
            {
                var rawContent = await jsonResponse.Content.ReadAsStringAsync().ConfigureAwait(false);
                response = JsonConvert.DeserializeObject<NftLoginUserModelResponse>(rawContent);
            }
            else if (jsonResponse.StatusCode == System.Net.HttpStatusCode.Unauthorized ||
                     jsonResponse.StatusCode == System.Net.HttpStatusCode.NotFound)
            {
                response = new NftLoginUserModelResponse
                {
                    Messages = new List<string>
                    {
                        "User not authorized."
                    }
                };
            }
            else
            {
                response = new NftLoginUserModelResponse
                {
                    Messages = new List<string>
                    {
                        "Internal server error."
                    }
                };
            }

            return response;
        }

        public async Task<NftLoginUserModelResponse> GetNftUser(string nftAddress)
        {
            NftLoginUserModelResponse response = null;
            var rawRequest = new SignatureRequest
            {
                Signature = nftAddress
            };

            var jsonResponse = await this.baseClient.PostAsync(rawRequest, Startup.StaticConfig["Endpoints:Marketplace:UserAPI"], Helpers.Extensions.GenerateJwtToken(null, null, Startup.StaticConfig["JWT:Marketplace:Key"])).ConfigureAwait(false);

            if (jsonResponse == null ||
                (jsonResponse.StatusCode != System.Net.HttpStatusCode.OK && jsonResponse.StatusCode != System.Net.HttpStatusCode.NotFound && jsonResponse.StatusCode != System.Net.HttpStatusCode.Unauthorized && jsonResponse.StatusCode != System.Net.HttpStatusCode.UnprocessableEntity))
            {
                response = new NftLoginUserModelResponse
                {
                    Messages = new List<string>
                    {
                        "Internal server error."
                    }
                };
            }
            else if (jsonResponse.StatusCode == System.Net.HttpStatusCode.OK)
            {
                var rawContent = await jsonResponse.Content.ReadAsStringAsync().ConfigureAwait(false);
                response = JsonConvert.DeserializeObject<NftLoginUserModelResponse>(rawContent);
            }
            else if (jsonResponse.StatusCode == System.Net.HttpStatusCode.Unauthorized ||
                     jsonResponse.StatusCode == System.Net.HttpStatusCode.NotFound)
            {
                response = new NftLoginUserModelResponse
                {
                    Messages = new List<string>
                    {
                        "User not authorized."
                    }
                };
            }
            else
            {
                response = new NftLoginUserModelResponse
                {
                    Messages = new List<string>
                    {
                        "Internal server error."
                    }
                };
            }

            return response;
        }

        public async Task<NftWithdrawalModelResponse> WithdrawNftCoins(string userNftAdress, string type, decimal amount)
        {
            NftWithdrawalModelResponse response = null;
            var rawNftWithdrawalRequest = new NftWithdrawalModelRequest
            {
                userNFTsAddress = userNftAdress,
                amount = amount,
                type = type,
            };

            var jsonString = JsonConvert.SerializeObject(rawNftWithdrawalRequest);
            var rawRequest = new SignatureRequest
            {
                Signature = Helpers.Extensions.AESEncryption(jsonString)
            };

            var jsonResponse = await this.baseClient.PutAsync(rawRequest, Startup.StaticConfig["Endpoints:Marketplace:WithdrawAPI"], Helpers.Extensions.GenerateJwtToken(null, null, Startup.StaticConfig["JWT:Marketplace:Key"])).ConfigureAwait(false);

            if (jsonResponse == null ||
                (jsonResponse.StatusCode != System.Net.HttpStatusCode.OK && jsonResponse.StatusCode != System.Net.HttpStatusCode.Unauthorized && jsonResponse.StatusCode != System.Net.HttpStatusCode.UnprocessableEntity))
            {
                response = new NftWithdrawalModelResponse
                {
                    Messages = new List<string>
                    {
                        "Internal server error."
                    }
                };
            }
            else if (jsonResponse.StatusCode == System.Net.HttpStatusCode.OK)
            {
                var rawContent = await jsonResponse.Content.ReadAsStringAsync().ConfigureAwait(false);
                response = JsonConvert.DeserializeObject<NftWithdrawalModelResponse>(rawContent);
            }
            else if (jsonResponse.StatusCode == System.Net.HttpStatusCode.Unauthorized)
            {
                response = new NftWithdrawalModelResponse
                {
                    Messages = new List<string>
                    {
                        "User not authorized."
                    }
                };
            }
            else
            {
                response = new NftWithdrawalModelResponse
                {
                    Messages = new List<string>
                    {
                        "Internal server error."
                    }
                };
            }

            return response;
        }

        private string GetCustomPlayerName(int index)
        {
            string name = null;

            if (index == 1)
            {
                name = "Amy";
            }
            else if (index == 2)
            {
                name = "Bella";
            }
            else if (index == 3)
            {
                name = "Alan";
            }
            else if (index == 4)
            {
                name = "Adrian";
            }
            else if (index == 5)
            {
                name = "Wendy";
            }
            else if (index == 6)
            {
                name = "Yvonne";
            }
            else if (index == 7)
            {
                name = "Justin";
            }
            else if (index == 8)
            {
                name = "Keith";
            }
            else if (index == 9)
            {
                name = "Peter";
            }
            else if (index == 10)
            {
                name = "Robert";
            }

            return name;
        }
    }
}

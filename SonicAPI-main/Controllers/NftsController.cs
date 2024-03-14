using AutoMapper;
using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Cors;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using SonicAPI.Helpers;
using SonicAPI.Interfaces;
using SonicAPI.Models.DataModels;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace SonicAPI
{
    [EnableCors("AllowAllHeaders")]
    public class NftsController : Controller
    {
        private IBaseService baseService;
        private IMapper mapper;

        public NftsController(IBaseService baseService, IMapper mapper)
        {
            this.baseService = baseService;
            this.mapper = mapper;
        }

        /// <summary>
        /// Get user model by user nft address.
        /// </summary>
        /// <returns>user model.</returns>
        [HttpPost("/nfts/users")]
        [JWTAuthorize]
        public async Task<IActionResult> GetUser([FromBody] SignatureRequest data)
        {
            try
            {
                if (!string.IsNullOrEmpty(data.Signature) && Extensions.IsBase64String(data.Signature)) 
                {
                    var userNftAddress = Extensions.AESDecryption(data.Signature);
                    var item = await this.baseService.GetUserByNftAddress(userNftAddress).ConfigureAwait(false);

                    if (item != null)
                    {
                        var model = this.mapper.Map<UserModel>(item);

                        return StatusCode(StatusCodes.Status200OK, model);
                    }
                    else
                    {
                        return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "User not found." }));
                    }
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Signature not in hash." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// Insert user model by user nft address.
        /// </summary>
        /// <returns>user model.</returns>
        [HttpPost("/nfts/users/create")]
        [JWTAuthorize]
        public async Task<IActionResult> InsertUser([FromBody] SignatureRequest data)
        {
            try
            {
                if (!string.IsNullOrEmpty(data.Signature) && Extensions.IsBase64String(data.Signature))
                {
                    var signature = Extensions.AESDecryption(data.Signature);
                    var signatureItems = signature.Split(':');

                    if (signatureItems.Length == 5)
                    {
                        var userNftAddress = signatureItems[0];
                        var userNftId = signatureItems[1];
                        var username = signatureItems[2];
                        var email = signatureItems[3];
                        double.TryParse(signatureItems[4], out var ts);
                        var timestamp = Extensions.UnixTimeStampToDateTime(ts);

                        var item = await this.baseService.GetUserByNftAddress(userNftAddress).ConfigureAwait(false);

                        if (item == null)
                        {
                            var flag = await this.baseService.InsertUser(userNftAddress, userNftId, username, email).ConfigureAwait(false);

                            if (!flag)
                            {
                                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - insert user failure." }));
                            }

                            item = await this.baseService.GetUserByNftAddress(userNftAddress).ConfigureAwait(false);

                            var model = this.mapper.Map<UserModel>(item);

                            return StatusCode(StatusCodes.Status200OK, model);
                        }
                        else
                        {
                            return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "User exists." }));
                        }
                    }
                    else
                    {
                        return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Signature not in hash." }));
                    }
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Signature not in hash." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// To deposit ESOR/SOR amount by signature.
        /// </summary>
        /// <returns>user model.</returns>
        [HttpPut("/nfts/users/deposit")]
        [JWTAuthorize]
        public async Task<IActionResult> DepositGameCoins([FromBody] SignatureRequest data)
        {
            try
            {
                if (!string.IsNullOrEmpty(data.Signature) && Extensions.IsBase64String(data.Signature))
                {
                    var signature = Extensions.AESDecryption(data.Signature);
                    var signatureItems = signature.Split(':');

                    if (signatureItems.Length == 4)
                    {
                        var userNftAddress = signatureItems[0];
                        var coinType = signatureItems[1];
                        decimal.TryParse(signatureItems[2], out var amount);
                        double.TryParse(signatureItems[3], out var ts);
                        var timestamp = Extensions.UnixTimeStampToDateTime(ts);

                        var item = await this.baseService.GetUserByNftAddress(userNftAddress).ConfigureAwait(false);

                        if (item != null)
                        {
                            var coins = item.Coins.Where(i => i.GameCoin.Type == coinType).ToList();

                            if (coins.Count > 0)
                            {
                                var totalAmount = coins.Sum(i => i.Amount);
                                var newAmount = (totalAmount + amount);
                                var flag = true;

                                if (newAmount != 0)
                                {
                                    flag = await this.baseService.UpdateUserESOR(item, newAmount).ConfigureAwait(false);

                                    if (!flag)
                                    {
                                        return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - update ESOR failure." }));
                                    }
                                }

                                var model = this.mapper.Map<UserModel>(item);

                                return StatusCode(StatusCodes.Status200OK, model);
                            }
                            else
                            {
                                return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "User coin not found." }));
                            }
                        }
                        else
                        {
                            return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "User not found." }));
                        }
                    }
                    else
                    {
                        return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Signature not in hash." }));
                    }
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Signature not in hash." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// Get Game modes model.
        /// </summary>
        /// <returns>game modes model.</returns>
        [HttpGet("/nfts/games/modes")]
        [JWTAuthorize]
        public async Task<IActionResult> GetGameModes()
        {
            try
            {
                var item = await this.baseService.GetGameModes().ConfigureAwait(false);

                if (item.Count > 0)
                {
                    var model = this.mapper.Map<List<SingleGameModeRuleModel>>(item);

                    return StatusCode(StatusCodes.Status200OK, model);
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game modes not found." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// Get Game spareparts model.
        /// </summary>
        /// <returns>game spareparts model.</returns>
        [HttpGet("/nfts/games/spareparts")]
        [JWTAuthorize]
        public async Task<IActionResult> GetGameSpareParts()
        {
            try
            {
                var item = await this.baseService.GetGameSpareParts().ConfigureAwait(false);

                if (item.Count > 0)
                {
                    var model = this.mapper.Map<List<GameSparePartModel>>(item);

                    return StatusCode(StatusCodes.Status200OK, model);
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game spare parts not found." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// Get Game coins model by game mode type.
        /// </summary>
        /// <returns>game coins model.</returns>
        [HttpGet("/nfts/games/modes/{type}/coins")]
        [JWTAuthorize]
        public async Task<IActionResult> GetGameCoinByMode(string type)
        {
            try
            {
                var item = await this.baseService.GetGameCoinsByMode(type).ConfigureAwait(false);

                if (item.Count > 0)
                {
                    var model = this.mapper.Map<List<SingleGameCoinRuleModel>>(item);

                    return StatusCode(StatusCodes.Status200OK, model);
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game coins not found." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// Get Game rewards model by game mode type.
        /// </summary>
        /// <param name="type">game mode type.</param>
        /// <returns>game rewards model.</returns>
        [HttpGet("/nfts/games/modes/{type}/rewards")]
        [JWTAuthorize]
        public async Task<IActionResult> GetGameRewardsByMode(string type)
        {
            try
            {
                var item = await this.baseService.GetGameRewardsByMode(type).ConfigureAwait(false);

                if (item.Count > 0)
                {
                    var model = this.mapper.Map<List<SingleGameRewardModel>>(item);

                    return StatusCode(StatusCodes.Status200OK, model);
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game rewards not found." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// To insert/update user nft item by signature.
        /// </summary>
        /// <returns>game spare part model.</returns>
        [HttpPut("/nfts/users/items")]
        [JWTAuthorize]
        public async Task<IActionResult> UpdateUserNftItems([FromBody] SignatureRequest data)
        {
            try
            {
                if (!string.IsNullOrEmpty(data.Signature) && Extensions.IsBase64String(data.Signature))
                {
                    var signature = Extensions.AESDecryption(data.Signature);
                    var signatureItems = signature.Split(':');

                    if (signatureItems.Length == 4)
                    {
                        var userNftAddress = signatureItems[0];
                        var itemNftAddress = signatureItems[1];
                        var itemType = signatureItems[2];
                        double.TryParse(signatureItems[3], out var ts);
                        var timestamp = Extensions.UnixTimeStampToDateTime(ts);

                        if (!string.IsNullOrEmpty(itemType) &&
                            (itemType.Equals("Character", StringComparison.InvariantCultureIgnoreCase) || itemType.Equals("SparePart", StringComparison.InvariantCultureIgnoreCase)))
                        {
                            var item = await this.baseService.GetUserByNftAddress(userNftAddress).ConfigureAwait(false);

                            if (item != null)
                            {
                                if (itemType.Equals("Character", StringComparison.InvariantCultureIgnoreCase))
                                {
                                    var userNftItem = await this.baseService.GetUserCharacterByNftAddress(itemNftAddress).ConfigureAwait(false);

                                    if (userNftItem != null)
                                    {
                                        var items = item.Characters.Where(i => i.GameCharacter.NftAddress == itemNftAddress).ToList();

                                        if (items.Count == 0)
                                        {
                                            var flag = await this.baseService.UpdateUserCharacter(item, userNftItem).ConfigureAwait(false);

                                            if (!flag)
                                            {
                                                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - update user character failure." }));
                                            }

                                            var model = this.mapper.Map<UserModel>(item);

                                            return StatusCode(StatusCodes.Status200OK, model);
                                        }
                                        else
                                        {
                                            return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "User character exists." }));
                                        }
                                    }
                                    else
                                    {
                                        var nftItem = await this.baseService.GetGameCharacterByNftAddress(itemNftAddress).ConfigureAwait(false);

                                        if (nftItem != null)
                                        {
                                            var items = item.Characters.Where(i => i.GameCharacter.NftAddress == itemNftAddress).ToList();

                                            if (items.Count == 0)
                                            {
                                                var flag = await this.baseService.InsertUserCharacter(item, nftItem).ConfigureAwait(false);

                                                if (!flag)
                                                {
                                                    return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - insert user character failure." }));
                                                }

                                                var model = this.mapper.Map<UserModel>(item);

                                                return StatusCode(StatusCodes.Status200OK, model);
                                            }
                                            else
                                            {
                                                return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "User character exists." }));
                                            }
                                        }
                                        else
                                        {
                                            return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Item not found." }));
                                        }
                                    }
                                }
                                else if (itemType.Equals("SparePart", StringComparison.InvariantCultureIgnoreCase))
                                {
                                    var userNftItem = await this.baseService.GetUserGameSparePartByNftAddress(itemNftAddress).ConfigureAwait(false);

                                    if (userNftItem != null)
                                    {
                                        var items = item.SpareParts.Where(i => i.GameSparePart.NftAddress == itemNftAddress).ToList();

                                        if (items.Count == 0)
                                        {
                                            var flag = await this.baseService.UpdateUserSparePart(item, userNftItem).ConfigureAwait(false);

                                            if (!flag)
                                            {
                                                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - update user spare part failure." }));
                                            }

                                            var model = this.mapper.Map<UserModel>(item);

                                            return StatusCode(StatusCodes.Status200OK, model);
                                        }
                                        else
                                        {
                                            return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "User spare part exists." }));
                                        }
                                    }
                                    else
                                    {
                                        var nftItem = await this.baseService.GetGameSparePartByNftAddress(itemNftAddress).ConfigureAwait(false);

                                        if (nftItem != null)
                                        {
                                            var items = item.SpareParts.Where(i => i.GameSparePart.NftAddress == itemNftAddress).ToList();

                                            if (items.Count == 0)
                                            {
                                                var flag = await this.baseService.InsertUserSparePart(item, nftItem).ConfigureAwait(false);

                                                if (!flag)
                                                {
                                                    return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - insert user spare part failure." }));
                                                }

                                                var model = this.mapper.Map<UserModel>(item);

                                                return StatusCode(StatusCodes.Status200OK, model);
                                            }
                                            else
                                            {
                                                return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "User spare part exists." }));
                                            }
                                        }
                                        else
                                        {
                                            return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Item not found." }));
                                        }
                                    }
                                }
                                else
                                {
                                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Item type is invalid." }));
                                }
                            }
                            else
                            {
                                return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "User not found." }));
                            }
                        }
                        else
                        {
                            return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Item type is invalid." }));
                        }
                    }
                    else
                    {
                        return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Signature not in hash." }));
                    }
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Signature not in hash." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// To update Game spare part rules.
        /// </summary>
        /// <param name="id">game spare part id.</param>
        /// <returns>game spare part model.</returns>
        [HttpPut("/nfts/game/spareparts/{id}")]
        [JWTAuthorize]
        public async Task<IActionResult> UpdateGameSparePartRules([FromBody] GameSparePartAttributeModel data, int id)
        {
            try
            {
                var item = await this.baseService.GetGameSparePartBySparePartId(id).ConfigureAwait(false);

                if (data != null &&
                    item != null)
                {
                    var flag = await this.baseService.UpdateGameSparePart(item, data).ConfigureAwait(false);

                    if (!flag)
                    {
                        return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - update game spare part failure." }));
                    }

                    var model = this.mapper.Map<GameSparePartModel>(item);

                    return StatusCode(StatusCodes.Status200OK, model);
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game spare parts not found." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// To update Game coin rules.
        /// </summary>
        /// <param name="type">game mode type.</param>
        /// <returns>game coins model.</returns>
        [HttpPut("/nfts/game/modes/{type}/coins")]
        [JWTAuthorize]
        public async Task<IActionResult> UpdateGameCoinRules([FromBody] List<GameCoinRuleModel> data, string type)
        {
            try
            {
                var items = await this.baseService.GetGameCoinsByMode(type).ConfigureAwait(false);

                if (data != null &&
                    items.Count > 0)
                {
                    var flag = await this.baseService.UpdateGameCoinsRules(items, data).ConfigureAwait(false);

                    if (!flag)
                    {
                        return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - update game coins rules failure." }));
                    }

                    var model = this.mapper.Map<List<SingleGameCoinRuleModel>>(items);

                    return StatusCode(StatusCodes.Status200OK, model);
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game coins not found." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// To update Game rewards rules.
        /// </summary>
        /// <returns>game rewards model.</returns>
        [HttpPut("/nfts/game/modes/{type}/rewards")]
        [JWTAuthorize]
        public async Task<IActionResult> UpdateGameRewardRules([FromBody] List<GameRewardModel> data, string type)
        {
            try
            {
                var items = await this.baseService.GetGameRewardsByMode(type).ConfigureAwait(false);

                if (data != null &&
                    items.Count > 0)
                {
                    var flag = await this.baseService.UpdateGameRewardRules(items, data).ConfigureAwait(false);

                    if (!flag)
                    {
                        return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - update game rewards rules failure." }));
                    }

                    var model = this.mapper.Map<List<SingleGameRewardModel>>(items);

                    return StatusCode(StatusCodes.Status200OK, model);
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game rewards not found." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }
    }
}
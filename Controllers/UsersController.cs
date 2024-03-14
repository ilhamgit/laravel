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
    public class UsersController : Controller
    {
        private IBaseService baseService;
        private IMapper mapper;

        public UsersController(IBaseService baseService, IMapper mapper)
        {
            this.baseService = baseService;
            this.mapper = mapper;
        }

        /// <summary>
        /// Generate JWT Token.
        /// </summary>
        /// <param name="data">login user data.</param>
        /// <returns>generated token.</returns>
        [AllowAnonymous]
        [HttpPost("/users/token")]
        public async Task<IActionResult> GenerateToken([FromBody] GenerateTokenRequest data)
        {
            try
            {
                var tokenString = Extensions.GenerateJwtToken(data.Id, data.SessionId);

                return StatusCode(StatusCodes.Status200OK, new GenerateTokenResponse
                {
                    TokenString = tokenString
                }); 
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// Generate JWT Token after successful login.
        /// </summary>
        /// <param name="data">login user data.</param>
        /// <returns>generated token.</returns>
        [AllowAnonymous]
        [HttpPost("/users/login")]
        public async Task<IActionResult> Login([FromBody] LoginUserModelRequest data)
        {
            try
            {
                //var rawPassword = string.Empty;
                var password = data.Password;

                //if (!string.IsNullOrEmpty(data.Password))
                //{
                //    password = Extensions.AESEncryption(data.Password);
                //    rawPassword = Extensions.AESDecryption(password);
                //}

                //PLACEHOLDER TO CALL TO THIRDPARTY FOR AUTHENTICATION
                var nftUser = await this.baseService.LoginNftUser(data.Username, password).ConfigureAwait(false);

                //var content = "{\r\n  \"TokenString\": null,\r\n  \"SessionId\": null,\r\n  \"UserId\": 1,\r\n  \"Username\": \"alice\",\r\n  \"Email\": \"alice@alice.com\",\r\n  \"Attributes\": {\r\n    \"Levels\": 1,\r\n    \"Experiences\": 10,\r\n    \"ElitePoints\": 0,\r\n    \"Trophies\": 0\r\n  },\r\n  \"Stamina\": {\r\n    \"Amount\": 150\r\n  },\r\n  \"Coins\": [\r\n    {\r\n      \"Type\": \"SOR\",\r\n      \"Amount\": 16.000\r\n    },\r\n    {\r\n      \"Type\": \"ESOR\",\r\n      \"Amount\": 16.000\r\n    }\r\n  ],\r\n  \"Characters\": [\r\n    {\r\n      \"GameCharacterId\": 1,\r\n      \"Name\": \"Chicken (Default)\",\r\n      \"Type\": \"Chicken\",\r\n      \"MaximumSpareParts\": 3,\r\n      \"IsOccupied\": false\r\n    },\r\n    {\r\n      \"GameCharacterId\": 2,\r\n      \"Name\": \"Hippo\",\r\n      \"Type\": \"Hippo\",\r\n      \"MaximumSpareParts\": 3,\r\n      \"IsOccupied\": false\r\n    },\r\n    {\r\n      \"GameCharacterId\": 3,\r\n      \"Name\": \"Racing\",\r\n      \"Type\": \"Racing\",\r\n      \"MaximumSpareParts\": 3,\r\n      \"IsOccupied\": false\r\n    }\r\n  ],\r\n  \"SpareParts\": [\r\n    {\r\n      \"GameSparePartId\": 1,\r\n      \"Name\": \"Tyre (N)\",\r\n      \"Type\": \"Tyre\",\r\n      \"Category\": \"N\",\r\n      \"IsOccupied\": false\r\n    },\r\n    {\r\n      \"GameSparePartId\": 13,\r\n      \"Name\": \"Engine (N)\",\r\n      \"Type\": \"Engine\",\r\n      \"Category\": \"N\",\r\n      \"IsOccupied\": false\r\n    },\r\n    {\r\n      \"GameSparePartId\": 17,\r\n      \"Name\": \"Exhaust (N)\",\r\n      \"Type\": \"Exhaust\",\r\n      \"Category\": \"N\",\r\n      \"IsOccupied\": false\r\n    },\r\n    {\r\n      \"GameSparePartId\": 21,\r\n      \"Name\": \"Furious\",\r\n      \"Type\": \"CarSkin\",\r\n      \"Category\": \"Furious\",\r\n      \"IsOccupied\": false\r\n    },\r\n    {\r\n      \"GameSparePartId\": 5,\r\n      \"Name\": \"Bonnet (N)\",\r\n      \"Type\": \"Bonnet\",\r\n      \"Category\": \"N\",\r\n      \"IsOccupied\": false\r\n    },\r\n    {\r\n      \"GameSparePartId\": 9,\r\n\"Name\": \"Wings (N)\",\r\n      \"Type\": \"Wings\",\r\n      \"Category\": \"N\",\r\n      \"IsOccupied\": false\r\n    }\r\n  ]\r\n}";
                //var item2 = JsonConvert.DeserializeObject<LoginUserModelResponse>(content);
                //return StatusCode(StatusCodes.Status200OK, item2);

                if (nftUser != null &&
                    nftUser.Messages.Count == 0)
                {
                    //var item = await this.baseService.GetUserByUsername(data.Username).ConfigureAwait(false);
                    var item = await this.baseService.GetUserByNftAddressAsNoTracking(nftUser.Wallet).ConfigureAwait(false);

                    if (item != null)
                    {
                        if (nftUser.Characters != null &&
                            nftUser.Characters.Count > 0)
                        {
                            var characterNftAddress = nftUser.Characters.Select(b => b.NftAddress).ToList();
                            var nonExistCharacters = item.Characters.Where(i => !string.IsNullOrEmpty(i.GameCharacter.NftAddress) && !characterNftAddress.Contains(i.GameCharacter.NftAddress)).ToList();

                            if (nonExistCharacters.Count > 0)
                            {
                                //remove missing linked nft characters
                                var flag = await this.baseService.DeleteUserCharacters(nonExistCharacters).ConfigureAwait(false);

                                if (!flag)
                                {
                                    return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - delete user characters failure." }));
                                }
                            }

                            var characters = await this.baseService.GetUserCharacters().ConfigureAwait(false);
                            var existingCharacterNftAddress = characters.Where(a => !string.IsNullOrEmpty(a.GameCharacter.NftAddress)).Select(b => b.GameCharacter.NftAddress).ToList();
                            var nonOccupiedCharacters = characters.Where(i => !string.IsNullOrEmpty(i.GameCharacter.NftAddress) && characterNftAddress.Contains(i.GameCharacter.NftAddress) && i.UserId != item.UserId).ToList();

                            if (nonOccupiedCharacters.Count > 0)
                            {
                                //update user nft characters
                                var flag = await this.baseService.UpdateUserCharacters(item.UserId, nonOccupiedCharacters).ConfigureAwait(false);

                                if (!flag)
                                {
                                    return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - update user characters failure." }));
                                }
                            }

                            var newCharacters = characterNftAddress.Where(i => !existingCharacterNftAddress.Contains(i)).ToList();

                            if (newCharacters.Count > 0)
                            {
                                //insert new user nft characters
                                var flag = await this.baseService.InsertUserCharacters(item.UserId, newCharacters).ConfigureAwait(false);

                                if (!flag)
                                {
                                    return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - insert user characters failure." }));
                                }
                            }
                        }

                        if (nftUser.SpareParts != null &&
                            nftUser.SpareParts.Count > 0)
                        {
                            var sparePartsNftAddress = nftUser.SpareParts.Select(b => b.NftAddress).ToList();
                            var nonExistSpareParts = item.SpareParts.Where(i => !string.IsNullOrEmpty(i.GameSparePart.NftAddress) && !sparePartsNftAddress.Contains(i.GameSparePart.NftAddress)).ToList();

                            if (nonExistSpareParts.Count > 0)
                            {
                                //remove missing linked nft spare parts
                                var flag = await this.baseService.DeleteUserSpareParts(nonExistSpareParts).ConfigureAwait(false);

                                if (!flag)
                                {
                                    return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - delete user spare parts failure." }));
                                }
                            }

                            var spareParts = await this.baseService.GetUserSpareParts().ConfigureAwait(false);
                            var existingSparePartsNftAddress = spareParts.Where(a => !string.IsNullOrEmpty(a.GameSparePart.NftAddress)).Select(b => b.GameSparePart.NftAddress).ToList();
                            var nonOccupiedSpareParts = spareParts.Where(i => !string.IsNullOrEmpty(i.GameSparePart.NftAddress) && sparePartsNftAddress.Contains(i.GameSparePart.NftAddress) && i.UserId != item.UserId).ToList();

                            if (nonOccupiedSpareParts.Count > 0)
                            {
                                //update user nft spare parts
                                var flag = await this.baseService.UpdateUserSpareParts(item.UserId, nonOccupiedSpareParts).ConfigureAwait(false);

                                if (!flag)
                                {
                                    return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - update user spare parts failure." }));
                                }
                            }

                            var newSpareParts = sparePartsNftAddress.Where(i => !existingSparePartsNftAddress.Contains(i)).ToList();

                            if (newSpareParts.Count > 0)
                            {
                                //insert new user nft spare parts
                                var flag = await this.baseService.InsertUserSpareParts(item.UserId, newSpareParts).ConfigureAwait(false);

                                if (!flag)
                                {
                                    return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - insert user spare parts failure." }));
                                }
                            }
                        }

                        item = await this.baseService.GetUser(item.UserId).ConfigureAwait(false);

                        var newGuid = Guid.NewGuid();
                        var tokenString = Extensions.GenerateJwtToken(item.UserId.ToString(), newGuid.ToString());

                        Task.Factory.StartNew(() => baseService.InsertUserLoginHistory(item.UserId, newGuid));

                        var model = this.mapper.Map<LoginUserModelResponse>(item);
                        model.TokenString = tokenString;
                        model.SessionId = newGuid.ToString();

                        return StatusCode(StatusCodes.Status200OK, model);
                    }
                    else
                    {
                        return StatusCode(StatusCodes.Status401Unauthorized, new ErrorMessage(new List<string> { "User not authorized." }));
                    }
                }
                else
                {
                    return StatusCode(StatusCodes.Status401Unauthorized, new ErrorMessage(new List<string> { "User not authorized by Marketplace." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// Logout user and clear last session id.
        /// </summary>
        /// <param name="data">login user data.</param>
        /// <returns>generated token.</returns>
        [AllowAnonymous]
        [HttpPost("/users/{id}/logout")]
        public async Task<IActionResult> Logout(long id)
        {
            try
            {
                var item = await this.baseService.UpdateUserLoginHistory(id).ConfigureAwait(false);

                if (item)
                {
                    return StatusCode(StatusCodes.Status200OK);
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "User not found." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// Get User Model by ID.
        /// </summary>
        /// <param name="id">user id.</param>
        /// <returns>user model.</returns>
        [HttpGet("/users/{id}")]
        [JWTAuthorize]
        public async Task<IActionResult> Get(long id)
        {
            try
            {
                var item = await this.baseService.GetUserAsNoTracking(id).ConfigureAwait(false);

                if (item != null)
                {
                    var nftAddress = string.Empty;

                    if (!string.IsNullOrEmpty(item.NftAddress))
                    {
                        nftAddress = Extensions.AESEncryption(item.NftAddress);
                    }

                    //PLACEHOLDER TO CALL TO THIRDPARTY FOR AUTHENTICATION
                    var nftUser = await this.baseService.GetNftUser(nftAddress).ConfigureAwait(false);

                    if (nftUser != null &&
                        nftUser.Messages.Count == 0)
                    {
                        if (nftUser.Characters != null &&
                            nftUser.Characters.Count > 0)
                        {
                            var characterNftAddress = nftUser.Characters.Select(b => b.NftAddress).ToList();
                            var nonExistCharacters = item.Characters.Where(i => !string.IsNullOrEmpty(i.GameCharacter.NftAddress) && !characterNftAddress.Contains(i.GameCharacter.NftAddress)).ToList();

                            if (nonExistCharacters.Count > 0)
                            {
                                //remove missing linked nft characters
                                var flag = await this.baseService.DeleteUserCharacters(nonExistCharacters).ConfigureAwait(false);

                                if (!flag)
                                {
                                    return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - delete user characters failure." }));
                                }
                            }

                            var characters = await this.baseService.GetUserCharacters().ConfigureAwait(false);
                            var existingCharacterNftAddress = characters.Where(a => !string.IsNullOrEmpty(a.GameCharacter.NftAddress)).Select(b => b.GameCharacter.NftAddress).ToList();
                            var nonOccupiedCharacters = characters.Where(i => !string.IsNullOrEmpty(i.GameCharacter.NftAddress) && characterNftAddress.Contains(i.GameCharacter.NftAddress) && i.UserId != item.UserId).ToList();
                            
                            if (nonOccupiedCharacters.Count > 0)
                            {
                                //update user nft characters
                                var flag = await this.baseService.UpdateUserCharacters(item.UserId, nonOccupiedCharacters).ConfigureAwait(false);

                                if (!flag)
                                {
                                    return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - update user characters failure." }));
                                }
                            }

                            var newCharacters = characterNftAddress.Where(i => !existingCharacterNftAddress.Contains(i)).ToList();

                            if (newCharacters.Count > 0)
                            {
                                //insert new user nft characters
                                var flag = await this.baseService.InsertUserCharacters(item.UserId, newCharacters).ConfigureAwait(false);

                                if (!flag)
                                {
                                    return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - insert user characters failure." }));
                                }
                            }
                        }

                        if (nftUser.SpareParts != null &&
                            nftUser.SpareParts.Count > 0)
                        {
                            var sparePartsNftAddress = nftUser.SpareParts.Select(b => b.NftAddress).ToList();
                            var nonExistSpareParts = item.SpareParts.Where(i => !string.IsNullOrEmpty(i.GameSparePart.NftAddress) && !sparePartsNftAddress.Contains(i.GameSparePart.NftAddress)).ToList();

                            if (nonExistSpareParts.Count > 0)
                            {
                                //remove missing linked nft spare parts
                                var flag = await this.baseService.DeleteUserSpareParts(nonExistSpareParts).ConfigureAwait(false);

                                if (!flag)
                                {
                                    return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - delete user spare parts failure." }));
                                }
                            }

                            var spareParts = await this.baseService.GetUserSpareParts().ConfigureAwait(false);
                            var existingSparePartsNftAddress = spareParts.Where(a => !string.IsNullOrEmpty(a.GameSparePart.NftAddress)).Select(b => b.GameSparePart.NftAddress).ToList();
                            var nonOccupiedSpareParts = spareParts.Where(i => !string.IsNullOrEmpty(i.GameSparePart.NftAddress) && sparePartsNftAddress.Contains(i.GameSparePart.NftAddress) && i.UserId != item.UserId).ToList();

                            if (nonOccupiedSpareParts.Count > 0)
                            {
                                //update user nft spare parts
                                var flag = await this.baseService.UpdateUserSpareParts(item.UserId, nonOccupiedSpareParts).ConfigureAwait(false);

                                if (!flag)
                                {
                                    return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - update user spare parts failure." }));
                                }
                            }

                            var newSpareParts = sparePartsNftAddress.Where(i => !existingSparePartsNftAddress.Contains(i)).ToList();

                            if (newSpareParts.Count > 0)
                            {
                                //insert new user nft spare parts
                                var flag = await this.baseService.InsertUserSpareParts(item.UserId, newSpareParts).ConfigureAwait(false);

                                if (!flag)
                                {
                                    return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - insert user spare parts failure." }));
                                }
                            }
                        }
                    }

                    item = await this.baseService.GetUser(id).ConfigureAwait(false);

                    var model = this.mapper.Map<UserModel>(item);

                    return StatusCode(StatusCodes.Status200OK, model);
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "User not found." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// To update IsOccupied onto selected character by user id.
        /// </summary>
        /// <param name="id">user id.</param>
        /// <param name="gameCharacterId">game character id.</param>
        /// <returns>user model.</returns>
        [HttpPut("/users/{id}/characters/{gameCharacterId}/occupy")]
        [JWTAuthorize]
        public async Task<IActionResult> OccupyCharacter(long id, int gameCharacterId)
        {
            try
            {
                var item = await this.baseService.GetUser(id).ConfigureAwait(false);

                if (item != null)
                {
                    var isExist = false;

                    if (item.Characters != null &&
                        item.Characters.Count > 0)
                    {
                        var character = item.Characters.Where(i => i.GameCharacterId == gameCharacterId).FirstOrDefault();

                        if (character != null)
                        {
                            isExist = true;

                            var selectedId = character.GameCharacter.GameCharacterId;
                            var newList = item.Characters;

                            foreach (var c in newList)
                            {
                                if (c.GameCharacterId == selectedId)
                                {
                                    c.IsOccupied = true;
                                }
                                else
                                {
                                    c.IsOccupied = false;
                                }
                            }

                            var flag = await this.baseService.UpdateUserCharactersIsOccupied(newList).ConfigureAwait(false);

                            if (!flag)
                            {
                                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - update user character isOccupied failure." }));
                            }
                        }
                    }
                    
                    if (!isExist)
                    {
                        return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game character not found under this user." }));
                    }

                    var model = this.mapper.Map<UserModel>(item);

                    return StatusCode(StatusCodes.Status200OK, model);
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "User not found." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// To update IsOccupied onto selected spare part by user id.
        /// </summary>
        /// <param name="id">user id.</param>
        /// <param name="request">game spare part id list.</param>
        /// <returns>user model.</returns>
        [HttpPut("/users/{id}/spareparts/occupy")]
        [JWTAuthorize]
        public async Task<IActionResult> OccupySparePart([FromBody] OccupyModelRequest request, long id)
        {
            try
            {
                var item = await this.baseService.GetUser(id).ConfigureAwait(false);

                if (item != null)
                {
                    var isExist = false;

                    if (item.Characters != null &&
                        item.Characters.Count > 0)
                    {
                        if (request.GameSpareParts != null &&
                            request.GameSpareParts.Count > 0)
                        {
                            isExist = request.GameSpareParts.Count == request.GameSpareParts.Where(i => item.SpareParts.Select(b => b.GameSparePartId).Contains(i)).Count();
                        }
                        else
                        {
                            isExist = true;
                        }

                        if (isExist)
                        {
                            var newList = item.SpareParts;

                            foreach (var c in newList)
                            {
                                if (request.GameSpareParts.Count > 0 &&
                                    request.GameSpareParts.Contains(c.GameSparePartId))
                                {
                                    c.IsOccupied = true;
                                }
                                else
                                {
                                    c.IsOccupied = false;
                                }
                            }

                            var flag = await this.baseService.UpdateUserSparePartsIsOccupied(newList).ConfigureAwait(false);

                            if (!flag)
                            {
                                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - update user character isOccupied failure." }));
                            }
                        }
                    }

                    if (!isExist)
                    {
                        return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game spare part not found under this user." }));
                    }

                    var model = this.mapper.Map<UserModel>(item);

                    return StatusCode(StatusCodes.Status200OK, model);
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "User not found." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// To withdraw SOR amount by user id.
        /// </summary>
        /// <param name="id">user id.</param>
        /// <returns>user model.</returns>
        [HttpPut("/users/{id}/SOR/withdraw")]
        [JWTAuthorize]
        public async Task<IActionResult> WithdrawSOR([FromBody] AmountModelRequest request, long id)
        {
            try
            {
                var item = await this.baseService.GetUser(id).ConfigureAwait(false);

                if (item != null)
                {
                    decimal.TryParse(request.Amount.ToString(), out var amount);
                    //convert into negative amount
                    var newAmount = amount < 0 ? amount : -amount;
                    var totalAmount = item.Coins.Where(i => i.GameCoin.Type == "SOR").Sum(i => i.Amount);
                    var insuffAmount = (totalAmount + newAmount);
                    var flag = true;

                    if (insuffAmount >= 0)
                    {
                        if (newAmount != 0)
                        {
                            //PLACEHOLDER TO CALL TO THIRDPARTY FOR WITHDRAW SOR SUCCESSFULLY.
                            var temp = await this.baseService.WithdrawNftCoins(item.NftAddress, "SOR", request.Amount).ConfigureAwait(false);

                            if (temp != null &&
                                temp.Messages.Count == 0)
                            {
                                flag = await this.baseService.UpdateUserSOR(item, insuffAmount).ConfigureAwait(false);

                                if (!flag)
                                {
                                    return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - update SOR failure." }));
                                }
                            }
                        }

                        var model = this.mapper.Map<UserModel>(item);

                        return StatusCode(StatusCodes.Status200OK, model);
                    }
                    else
                    {
                        return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Insufficient ESOR by user." }));
                    }
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "User not found." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// To withdraw ESOR amount by user id.
        /// </summary>
        /// <param name="id">user id.</param>
        /// <returns>user model.</returns>
        [HttpPut("/users/{id}/ESOR/withdraw")]
        [JWTAuthorize]
        public async Task<IActionResult> WithdrawESOR([FromBody] AmountModelRequest request, long id)
        {
            try
            {
                var item = await this.baseService.GetUser(id).ConfigureAwait(false);

                if (item != null)
                {
                    decimal.TryParse(request.Amount.ToString(), out var amount);
                    //convert into negative amount
                    var newAmount = amount < 0 ? amount : -amount;
                    var totalAmount = item.Coins.Where(i => i.GameCoin.Type == "ESOR").Sum(i => i.Amount);
                    var insuffAmount = (totalAmount + newAmount);
                    var flag = true;

                    if (insuffAmount >= 0)
                    {
                        if (newAmount != 0)
                        {
                            //PLACEHOLDER TO CALL TO THIRDPARTY FOR WITHDRAW ESOR SUCCESSFULLY.
                            var temp = await this.baseService.WithdrawNftCoins(item.NftAddress, "ESOR", request.Amount).ConfigureAwait(false);

                            if (temp != null &&
                                temp.Messages.Count == 0)
                            {
                                flag = await this.baseService.UpdateUserESOR(item, insuffAmount).ConfigureAwait(false);

                                if (!flag)
                                {
                                    return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - update ESOR failure." }));
                                }
                            }
                        }

                        var model = this.mapper.Map<UserModel>(item);

                        return StatusCode(StatusCodes.Status200OK, model);
                    }
                    else
                    {
                        return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Insufficient ESOR by user." }));
                    }
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "User not found." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// To deduct stamina amount been used in match by user id.
        /// </summary>
        /// <param name="id">user id.</param>
        /// <returns>user model.</returns>
        [HttpPut("/users/{id}/stamina/deduct")]
        [JWTAuthorize]
        public async Task<IActionResult> DeductStamina([FromBody] AmountModelRequest request, long id)
        {
            try
            {
                var item = await this.baseService.GetUser(id).ConfigureAwait(false);

                if (item != null)
                {
                    int.TryParse(request.Amount.ToString(), out var amount);
                    //convert into negative amount
                    var newAmount = amount < 0 ? amount : -amount;
                    var totalAmount = item.Stamina.Sum(i => i.Amount);
                    var insuffAmount = (totalAmount + newAmount);
                    var flag = true;

                    if (insuffAmount >= 0)
                    {
                        if (newAmount != 0)
                        {
                            flag = await this.baseService.InsertUserStamina(id, newAmount).ConfigureAwait(false);

                            if (!flag)
                            {
                                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - insert stamina failure." }));
                            }
                        }

                        var model = this.mapper.Map<UserModel>(item);

                        return StatusCode(StatusCodes.Status200OK, model);
                    }
                    else
                    {
                        return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Insufficient stamina by user." }));
                    }
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "User not found." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// To deduct ESOR amount been used in match by user id.
        /// </summary>
        /// <param name="id">user id.</param>
        /// <returns>user model.</returns>
        [HttpPut("/users/{id}/ESOR/deduct")]
        [JWTAuthorize]
        public async Task<IActionResult> DeductESOR([FromBody] AmountModelRequest request, long id)
        {
            try
            {
                var item = await this.baseService.GetUser(id).ConfigureAwait(false);

                if (item != null)
                {
                    decimal.TryParse(request.Amount.ToString(), out var amount);
                    //convert into negative amount
                    var newAmount = amount < 0 ? amount : -amount;
                    var totalAmount = item.Coins.Where(i => i.GameCoin.Type == "ESOR").Sum(i => i.Amount);
                    var insuffAmount = (totalAmount + newAmount);
                    var flag = true;

                    if (insuffAmount >= 0)
                    {
                        if (newAmount != 0)
                        {
                            flag = await this.baseService.UpdateUserESOR(item, insuffAmount).ConfigureAwait(false);

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
                        return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Insufficient ESOR by user." }));
                    }
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "User not found." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// To update experience, level, SOR, ESOR (include game coin reward + collected coin) by user id.
        /// </summary>
        /// <param name="id">user id.</param>
        /// <returns>user model.</returns>
        [HttpPut("/users/{id}/rewards")]
        [JWTAuthorize]
        public async Task<IActionResult> UpdateUserRewards([FromBody] UserAttributeModelRequest request, long id)
        {
            try
            {
                var item = await this.baseService.GetUser(id).ConfigureAwait(false);

                if (item != null)
                {
                    var attributes = item.Attributes;

                    if (attributes != null)
                    {
                        attributes.Levels = request.Levels;
                        attributes.Experiences = request.Experiences;

                        if (request.Levels > 0 &&
                            request.Experiences >= 0)
                        {
                            var flag = await this.baseService.UpdateUserExperiences(id, attributes).ConfigureAwait(false);

                            if (!flag)
                            {
                                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - update user experiences failure." }));
                            }
                        }
                        else
                        {
                            return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Invalid experience level by user." }));
                        }
                    }
                    else
                    {
                        attributes = new Models.DbSets.UserAttribute
                        {
                            UserId = id,
                            Levels = request.Levels,
                            Experiences = request.Experiences,
                            ElitePoints = 0,
                            Trophies = 0
                        };

                        var flag = await this.baseService.InsertUserExperiences(id, attributes).ConfigureAwait(false);

                        if (!flag)
                        {
                            return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - insert user experiences failure." }));
                        }
                    }

                    var existCoins = item.Coins != null && item.Coins.Count > 0;

                    if (request.SOR != 0)
                    {
                        if (existCoins)
                        {
                            var coin = item.Coins.Where(i => i.GameCoin.Type == "SOR").FirstOrDefault();

                            if (coin != null)
                            {
                                var amount = coin.Amount + request.SOR;
                                var flag = await this.baseService.UpdateUserSOR(item, amount).ConfigureAwait(false);

                                if (!flag)
                                {
                                    return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - update SOR failure." }));
                                }
                            }
                            else
                            {
                                var flag = await this.baseService.InsertUserSOR(item, request.SOR).ConfigureAwait(false);

                                if (!flag)
                                {
                                    return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - insert SOR failure." }));
                                }
                            }
                        }
                        else
                        {
                            var flag = await this.baseService.InsertUserSOR(item, request.SOR).ConfigureAwait(false);

                            if (!flag)
                            {
                                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - insert SOR failure." }));
                            }
                        }
                    }

                    if (request.ESOR != 0)
                    {
                        if (existCoins)
                        {
                            var coin = item.Coins.Where(i => i.GameCoin.Type == "ESOR").FirstOrDefault();

                            if (coin != null)
                            {
                                var amount = coin.Amount + request.ESOR;
                                var flag = await this.baseService.UpdateUserESOR(item, amount).ConfigureAwait(false);

                                if (!flag)
                                {
                                    return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - update ESOR failure." }));
                                }
                            }
                            else
                            {
                                var flag = await this.baseService.InsertUserESOR(item, request.ESOR).ConfigureAwait(false);

                                if (!flag)
                                {
                                    return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - insert ESOR failure." }));
                                }
                            }
                        }
                        else
                        {
                            var flag = await this.baseService.InsertUserESOR(item, request.ESOR).ConfigureAwait(false);

                            if (!flag)
                            {
                                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error - insert ESOR failure." }));
                            }
                        }
                    }

                    var model = this.mapper.Map<UserModel>(item);

                    return StatusCode(StatusCodes.Status200OK, model);
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "User not found." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }
    }
}

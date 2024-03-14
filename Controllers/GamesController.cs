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
    public class GamesController : Controller
    {
        private IBaseService baseService;
        private IMapper mapper;

        public GamesController(IBaseService baseService, IMapper mapper)
        {
            this.baseService = baseService;
            this.mapper = mapper;
        }

        /// <summary>
        /// Validate game app version.
        /// </summary>
        /// <returns>bool.</returns>
        [HttpGet("/games/validate/{version}")]
        public async Task<IActionResult> ValidateAppVersion(string version)
        {
            var actualAppVersion = Startup.StaticConfig["App:Version"];

            return StatusCode(StatusCodes.Status200OK, actualAppVersion == version);
        }

        /// <summary>
        /// Get Game details model.
        /// </summary>
        /// <returns>game details model.</returns>
        [HttpGet("/games")]
        [JWTAuthorize]
        public async Task<IActionResult> Get()
        {
            try
            {
                var games = await this.baseService.GetGames().ConfigureAwait(false);
                var spareParts = await this.baseService.GetGameSpareParts().ConfigureAwait(false);

                if (games.Count > 0 &&
                    spareParts.Count > 0)
                {
                    var modelGames = this.mapper.Map<List<GameModeModel>>(games);
                    var modelSpareParts = this.mapper.Map<List<GameSparePartModel>>(spareParts);
                    var model = new GameModelResponse
                    {
                        Modes = modelGames,
                        SpareParts = modelSpareParts
                    };

                    return StatusCode(StatusCodes.Status200OK, model);
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game details not found." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// Get Game coins model.
        /// </summary>
        /// <returns>game coins model.</returns>
        [HttpGet("/games/coins")]
        [JWTAuthorize]
        public async Task<IActionResult> GetGameCoins()
        {
            try
            {
                var item = await this.baseService.GetGameCoins().ConfigureAwait(false);

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
        /// Get Game items model.
        /// </summary>
        /// <returns>game items model.</returns>
        [HttpGet("/games/items")]
        [JWTAuthorize]
        public async Task<IActionResult> GetGameItems()
        {
            try
            {
                var item = await this.baseService.GetGameItems().ConfigureAwait(false);

                if (item.Count > 0)
                {
                    var model = this.mapper.Map<List<SingleGameItemRuleModel>>(item);

                    return StatusCode(StatusCodes.Status200OK, model);
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game items not found." }));
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
        [HttpGet("/games/modes")]
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
        /// Get Game rewards model.
        /// </summary>
        /// <returns>game rewards model.</returns>
        [HttpGet("/games/rewards")]
        [JWTAuthorize]
        public async Task<IActionResult> GetGameRewards()
        {
            try
            {
                var item = await this.baseService.GetGameRewards().ConfigureAwait(false);

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
        /// Get Game spareparts model.
        /// </summary>
        /// <returns>game spareparts model.</returns>
        [HttpGet("/games/spareparts")]
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
        /// Get Game rewards model by game mode type.
        /// </summary>
        /// <param name="type">game mode type.</param>
        /// <returns>game rewards model.</returns>
        [HttpGet("/games/modes/{type}/rewards")]
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
        /// Get Game match count by game mode type.
        /// </summary>
        /// <param name="type">game mode type.</param>
        /// <returns>game match count.</returns>
        [HttpGet("/games/modes/{type}/matches/count")]
        [JWTAuthorize]
        public async Task<IActionResult> GetMatchCountByMode(string type)
        {
            try
            {
                var item = await this.baseService.GetMatchCountByMode(type).ConfigureAwait(false);

                return StatusCode(StatusCodes.Status200OK, item);
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// Get Game match count by game mode type and skip X number.
        /// </summary>
        /// <param name="type">game mode type.</param>
        /// <returns>game match count.</returns>
        [HttpGet("/games/modes/{type}/matches/skip/{number}")]
        [JWTAuthorize]
        public async Task<IActionResult> GetMatchDetailsByModeAndSkipX(string type, int number)
        {
            try
            {
                var item = await this.baseService.GetMatchDetailsByModeAndSkipX(type, number).ConfigureAwait(false);

                if (item != null &&
                    item.Details != null &&
                    item.Details.Count > 0)
                {
                    var rawModel = this.mapper.Map<List<GameMatchDetailModel>>(item.Details);
                    var model = ProcessGameMatchDetailResponseModel(rawModel);

                    return StatusCode(StatusCodes.Status200OK, model);
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game match details not found." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// Get player game match count by game mode type.
        /// </summary>
        /// <param name="type">game mode type.</param>
        /// <param name="id">user id.</param>
        /// <returns>game match count.</returns>
        [HttpGet("/games/modes/{type}/matches/users/{id}/count")]
        [JWTAuthorize]
        public async Task<IActionResult> GetPlayerMatchCountByMode(string type, long id)
        {
            try
            {
                var item = await this.baseService.GetMatchCountByMode(type, id).ConfigureAwait(false);

                return StatusCode(StatusCodes.Status200OK, item);
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// Get player game match count by game mode type and skip X number.
        /// </summary>
        /// <param name="type">game mode type.</param>
        /// <param name="number">skip X number.</param>
        /// <param name="id">user id.</param>
        /// <returns>game match count.</returns>
        [HttpGet("/games/modes/{type}/matches/users/{id}/skip/{number}")]
        [JWTAuthorize]
        public async Task<IActionResult> GetPlayerMatchDetailsByModeAndSkipX(string type, int number, long id)
        {
            try
            {
                var item = await this.baseService.GetMatchDetailsByModeAndSkipX(type, number, id).ConfigureAwait(false);

                if (item != null &&
                    item.Details != null &&
                    item.Details.Count > 0)
                {
                    var rawModel = this.mapper.Map<List<GameMatchDetailModel>>(item.Details);
                    var model = ProcessGameMatchDetailResponseModel(rawModel);

                    return StatusCode(StatusCodes.Status200OK, model);
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game match details not found." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// Get Game leaderboard by top X.
        /// </summary>
        /// <param name="number">top X number.</param>
        /// <returns>game leaderboard model.</returns>
        [HttpGet("/games/leaderboards/top/{number}")]
        [JWTAuthorize]
        public async Task<IActionResult> GetLeaderboardByTopX(int number)
        {
            try
            {
                var item = await this.baseService.GetLeaderboardByTopX(number).ConfigureAwait(false);

                if (item.Count > 0)
                {
                    var model = this.mapper.Map<List<GameLeaderboardModel>>(item);

                    return StatusCode(StatusCodes.Status200OK, model);
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game leaderboard not found." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// Insert Game match id by game mode type before game starts.
        /// </summary>
        /// <param name="type">game mode type.</param>
        /// <returns>game match id.</returns>
        [HttpPost("/games/modes/{type}/matches")]
        [JWTAuthorize]
        public async Task<IActionResult> InsertMatchIdByMode(string type)
        {
            try
            {
                var mode = await this.baseService.GetGameModeByType(type).ConfigureAwait(false);

                if (mode != null)
                {
                    var item = await this.baseService.InsertMatchIdByGameModeId(mode.GameModeId).ConfigureAwait(false);

                    return StatusCode(StatusCodes.Status200OK, item);
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game mode type not found." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// Insert Game match id by game mode type and unique id before game starts.
        /// </summary>
        /// <param name="type">game mode type.</param>
        /// <param name="uniqueId">game unique id.</param>
        /// <returns>game match id.</returns>
        [HttpPost("/games/modes/{type}/matches/uniqueid/{uniqueId}")]
        [JWTAuthorize]
        public async Task<IActionResult> InsertMatchIdByModeAndUniqueId(string type, string uniqueId)
        {
            try
            {
                var mode = await this.baseService.GetGameModeByType(type).ConfigureAwait(false);

                if (mode != null)
                {
                    var item = await this.baseService.InsertMatchIdByGameModeIdAndUniqueId(mode.GameModeId, uniqueId).ConfigureAwait(false);

                    return StatusCode(StatusCodes.Status200OK, item);
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game mode type not found." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// Get Game match details by game mode type and game match id.
        /// </summary>
        /// <param name="type">game mode type.</param>
        /// <param name="id">game match id.</param>
        /// <returns>game match details model.</returns>
        [HttpGet("/games/modes/{type}/matches/{id}")]
        [JWTAuthorize]
        public async Task<IActionResult> GetMatchDetailsByModeAndMatchId(string type, long id)
        {
            try
            {
                var item = await this.baseService.GetMatchDetailListByModeAndMatchId(type, id).ConfigureAwait(false);

                if (item.Count > 0)
                {
                    var rawModel = this.mapper.Map<List<GameMatchDetailModel>>(item);
                    var model = ProcessGameMatchDetailResponseModel(rawModel);

                    return StatusCode(StatusCodes.Status200OK, model);
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game match details not found." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// Get Game match details by game mode type and unique id.
        /// </summary>
        /// <param name="type">game mode type.</param>
        /// <param name="uniqueId">game unique id.</param>
        /// <returns>game match details model.</returns>
        [HttpGet("/games/modes/{type}/matches/uniqueid/{uniqueId}")]
        [JWTAuthorize]
        public async Task<IActionResult> GetMatchDetailsByModeAndUniqueId(string type, string uniqueId)
        {
            try
            {
                var item = await this.baseService.GetMatchDetailListByModeAndUniqueId(type, uniqueId).ConfigureAwait(false);

                if (item.Count > 0)
                {
                    var rawModel = this.mapper.Map<List<GameMatchDetailModel>>(item);
                    var model = ProcessGameMatchDetailResponseModel(rawModel);

                    return StatusCode(StatusCodes.Status200OK, model);
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game match details not found." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// Insert Game match details by game mode type before game starts.
        /// </summary>
        /// <param name="type">game mode type.</param>
        /// <returns>game match id.</returns>
        [HttpPost("/games/modes/{type}/matches/{id}")]
        [JWTAuthorize]
        public async Task<IActionResult> InsertMatchDetailsByModeAndId([FromBody] List<SingleGameMatchDetailModelRequest> data, string type, long id)
        {
            try
            {
                if (data != null && data.Count > 0)
                {
                    var isZeroPlayerRanking = data.FindAll(i => i.PlayerRanking <= 0).Count;
                    var distinctPlayerRanking = data.Select(i => i.PlayerRanking).Distinct().ToList();

                    if (isZeroPlayerRanking == 0 && distinctPlayerRanking.Count == data.Count)
                    {
                        var item = await this.baseService.GetMatchDetailsByModeAndId(type, id).ConfigureAwait(false);

                        if (item != null)
                        {
                            var flag = await this.baseService.InsertMatchDetails(data, id).ConfigureAwait(false);

                            if (flag)
                            {
                                var rewards = await this.baseService.GetGameRewardsByMode(type).ConfigureAwait(false);

                                if (rewards.Count > 0)
                                {
                                    flag = await this.baseService.UpdateUserRewards(data, rewards).ConfigureAwait(false);

                                    if (flag)
                                    {
                                        return StatusCode(StatusCodes.Status200OK);
                                    }
                                    else
                                    {
                                        return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game player rewards are not updated." }));
                                    }
                                }
                                else
                                {
                                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game rewards not found." }));
                                }
                            }
                            else
                            {
                                return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game match details not inserted." }));
                            }
                        }
                        else
                        {
                            return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game match not found or contains match details." }));
                        }
                    }
                    else
                    {
                        var errorMsgs = new List<string>();

                        if (isZeroPlayerRanking > 0)
                        {
                            errorMsgs.Add("Game match details contain invalid player ranking.");
                        }

                        if (distinctPlayerRanking.Count != data.Count)
                        {
                            errorMsgs.Add("Game match details contain duplicated player ranking.");
                        }

                        return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(errorMsgs));
                    }
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game match details not found in request." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// Insert single game match details by game mode type and unique id before game starts.
        /// </summary>
        /// <param name="type">game mode type.</param>
        /// <param name="uniqueId">game unique id.</param>
        /// <returns>game match id.</returns>
        [HttpPost("/games/modes/{type}/matches/uniqueid/{uniqueId}/single")]
        [JWTAuthorize]
        public async Task<IActionResult> InsertSingleMatchDetailByModeAndUniqueId([FromBody] SingleGameMatchDetailModelRequest data, string type, string uniqueId)
        {
            try
            {
                if (data != null)
                {
                    var isZeroPlayerRanking = data.PlayerRanking <= 0;

                    if (!isZeroPlayerRanking)
                    {
                        var item = await this.baseService.GetMatchDetailsByModeAndUniqueId(type, uniqueId, true).ConfigureAwait(false);

                        if (item != null)
                        {
                            var passed = true;

                            if (item.Details != null &&
                                item.Details.Count > 0)
                            {
                                passed = !item.Details.Exists(i => i.PlayerRanking == data.PlayerRanking);
                            }

                            if (passed)
                            {
                                var flag = await this.baseService.InsertSingleMatchDetails(data, item.GameMatchId).ConfigureAwait(false);

                                if (flag)
                                {
                                    var rewards = await this.baseService.GetGameRewardsByMode(type).ConfigureAwait(false);

                                    if (rewards.Count > 0)
                                    {
                                        flag = await this.baseService.UpdateSingleUserRewards(data, rewards).ConfigureAwait(false);

                                        if (flag)
                                        {
                                            return StatusCode(StatusCodes.Status200OK);
                                        }
                                        else
                                        {
                                            return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Single game player rewards are not updated." }));
                                        }
                                    }
                                    else
                                    {
                                        return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game rewards not found." }));
                                    }
                                }
                                else
                                {
                                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Single game match details not inserted." }));
                                }
                            }
                            else
                            {
                                return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Single game match details duplicated with player ranking." }));
                            }
                        }
                        else
                        {
                            return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game match not found." }));
                        }
                    }
                    else
                    {
                        var errorMsgs = new List<string>();

                        if (isZeroPlayerRanking)
                        {
                            errorMsgs.Add("Single game match detail contain invalid player ranking.");
                        }

                        return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(errorMsgs));
                    }
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Single game match details not found in request." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// Insert game match detail list by game mode type and unique id before game starts.
        /// </summary>
        /// <param name="type">game mode type.</param>
        /// <param name="uniqueId">game unique id.</param>
        /// <returns>game match id.</returns>
        [HttpPost("/games/modes/{type}/matches/uniqueid/{uniqueId}/list")]
        [JWTAuthorize]
        public async Task<IActionResult> InsertSingleMatchDetailByModeAndUniqueId([FromBody] List<SingleGameMatchDetailModelRequest> data, string type, string uniqueId)
        {
            try
            {
                if (data != null)
                {
                    var isZeroPlayerRanking = data.FindAll(i => i.PlayerRanking <= 0).Count;
                    var distinctPlayerRanking = data.Select(i => i.PlayerRanking).Distinct().ToList();

                    if (isZeroPlayerRanking == 0 && distinctPlayerRanking.Count == data.Count)
                    {
                        var item = await this.baseService.GetMatchDetailsByModeAndUniqueId(type, uniqueId, true).ConfigureAwait(false);

                        if (item != null)
                        {
                            var passed = true;

                            if (item.Details != null && item.Details.Count > 0)
                            {
                                passed = false;
                            }

                            if (passed)
                            {
                                var flag = await this.baseService.InsertMatchDetails(data, item.GameMatchId).ConfigureAwait(false);

                                if (flag)
                                {
                                    var rewards = await this.baseService.GetGameRewardsByMode(type).ConfigureAwait(false);

                                    if (rewards.Count > 0)
                                    {
                                        flag = await this.baseService.UpdateUserRewards(data, rewards).ConfigureAwait(false);

                                        if (flag)
                                        {
                                            return StatusCode(StatusCodes.Status200OK);
                                        }
                                        else
                                        {
                                            return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game player rewards are not updated." }));
                                        }
                                    }
                                    else
                                    {
                                        return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game rewards not found." }));
                                    }
                                }
                                else
                                {
                                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game match details not inserted." }));
                                }
                            }
                            else
                            {
                                return StatusCode(StatusCodes.Status200OK);
                            }
                        }
                        else
                        {
                            return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game match not found." }));
                        }
                    }
                    else
                    {
                        var errorMsgs = new List<string>();

                        if (isZeroPlayerRanking > 0)
                        {
                            errorMsgs.Add("Game match details contain invalid player ranking.");
                        }

                        if (distinctPlayerRanking.Count != data.Count)
                        {
                            errorMsgs.Add("Game match details contain duplicated player ranking.");
                        }

                        return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(errorMsgs));
                    }
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game match details not found in request." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        /// <summary>
        /// Get Match Details by Insert game match detail list by game mode type and unique id before game starts.
        /// </summary>
        /// <param name="type">game mode type.</param>
        /// <param name="uniqueId">game unique id.</param>
        /// <returns>game match id.</returns>
        [HttpPost("/games/modes/{type}/matches/uniqueid/{uniqueId}/list/details")]
        [JWTAuthorize]
        public async Task<IActionResult> GetMatchDetailsByInsertSingleMatchDetailByModeAndUniqueId([FromBody] List<SingleGameMatchDetailModelRequest> data, string type, string uniqueId)
        {
            try
            {
                if (data != null)
                {
                    var isZeroPlayerRanking = data.FindAll(i => i.PlayerRanking <= 0).Count;
                    var distinctPlayerRanking = data.Select(i => i.PlayerRanking).Distinct().ToList();

                    if (isZeroPlayerRanking == 0 && distinctPlayerRanking.Count == data.Count)
                    {
                        var item = await this.baseService.GetMatchDetailsByModeAndUniqueId(type, uniqueId, true).ConfigureAwait(false);

                        if (item != null)
                        {
                            var passed = true;

                            if (item.Details != null && item.Details.Count > 0)
                            {
                                passed = false;
                            }

                            if (passed)
                            {
                                var flag = await this.baseService.InsertMatchDetails(data, item.GameMatchId).ConfigureAwait(false);

                                if (flag)
                                {
                                    var rewards = await this.baseService.GetGameRewardsByMode(type).ConfigureAwait(false);

                                    if (rewards.Count > 0)
                                    {
                                        flag = await this.baseService.UpdateUserRewards(data, rewards).ConfigureAwait(false);

                                        if (flag)
                                        {
                                            var list = await this.baseService.GetMatchDetailListByModeAndUniqueId(type, uniqueId).ConfigureAwait(false);

                                            if (list.Count > 0)
                                            {
                                                var rawModel = this.mapper.Map<List<GameMatchDetailModel>>(list);
                                                var model = ProcessGameMatchDetailResponseModel(rawModel);

                                                return StatusCode(StatusCodes.Status200OK, model);
                                            }
                                            else
                                            {
                                                return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game match details not found." }));
                                            }
                                        }
                                        else
                                        {
                                            return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game player rewards are not updated." }));
                                        }
                                    }
                                    else
                                    {
                                        return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game rewards not found." }));
                                    }
                                }
                                else
                                {
                                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game match details not inserted." }));
                                }
                            }
                            else
                            {
                                var list = await this.baseService.GetMatchDetailListByModeAndUniqueId(type, uniqueId).ConfigureAwait(false);

                                if (list.Count > 0)
                                {
                                    var rawModel = this.mapper.Map<List<GameMatchDetailModel>>(list);
                                    var model = ProcessGameMatchDetailResponseModel(rawModel);

                                    return StatusCode(StatusCodes.Status200OK, model);
                                }
                                else
                                {
                                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game match details not found." }));
                                }
                            }
                        }
                        else
                        {
                            return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game match not found." }));
                        }
                    }
                    else
                    {
                        var errorMsgs = new List<string>();

                        if (isZeroPlayerRanking > 0)
                        {
                            errorMsgs.Add("Game match details contain invalid player ranking.");
                        }

                        if (distinctPlayerRanking.Count != data.Count)
                        {
                            errorMsgs.Add("Game match details contain duplicated player ranking.");
                        }

                        return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(errorMsgs));
                    }
                }
                else
                {
                    return StatusCode(StatusCodes.Status422UnprocessableEntity, new ErrorMessage(new List<string> { "Game match details not found in request." }));
                }
            }
            catch (Exception ex)
            {
                return StatusCode(StatusCodes.Status500InternalServerError, new ErrorMessage(new List<string> { "Internal server error." }));
            }
        }

        private List<GameMatchDetailResponseModel> ProcessGameMatchDetailResponseModel(List<GameMatchDetailModel> rawModel)
        {
            var model = new List<GameMatchDetailResponseModel>();
            foreach (var m in rawModel)
            {
                if ((m.User != null) ||
                    (m.User == null && string.IsNullOrEmpty(m.CustomPlayerName)))
                {
                    model.Add(new GameMatchDetailResponseModel
                    {
                        PlayerRanking = m.PlayerRanking,
                        User = m.User,
                        LapTime = m.LapTime
                    });
                }
                else if (!string.IsNullOrEmpty(m.CustomPlayerName))
                {
                    model.Add(new GameMatchDetailResponseModel
                    {
                        PlayerRanking = m.PlayerRanking,
                        User = new SingleUserModel
                        {
                            Username = m.CustomPlayerName
                        },
                        LapTime = m.LapTime
                    });
                }
            }

            return model;
        }
    }
}

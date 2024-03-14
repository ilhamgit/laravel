using AutoMapper;
using SonicAPI.Models.DataModels;
using SonicAPI.Models.DbSets;
using System.Collections.Generic;
using System.Linq;

namespace SonicAPI.Models
{
    public class AutoMapperProfile : Profile
    {
        public AutoMapperProfile()
        {
            CreateMap<UserAttribute, UserAttributeModel>();

            CreateMap<List<UserStamina>, UserStaminaModel>()
                .ForMember(dest => dest.Amount, opt => opt.MapFrom(src => src.Sum(i => i.Amount)));

            CreateMap<UserCoin, UserCoinModel>()
                .ForMember(dest => dest.Type, opt => opt.MapFrom(src => src.GameCoin.Type));

            CreateMap<UserCharacter, UserCharacterModel>()
                .ForMember(dest => dest.GameCharacterId, opt => opt.MapFrom(src => src.GameCharacter.GameCharacterId))
                .ForMember(dest => dest.Name, opt => opt.MapFrom(src => src.GameCharacter.Name))
                .ForMember(dest => dest.Type, opt => opt.MapFrom(src => src.GameCharacter.Type))
                .ForMember(dest => dest.MaximumSpareParts, opt => opt.MapFrom(src => src.GameCharacter.MaximumSpareParts));

            CreateMap<UserSparePart, UserSparePartModel>()
                .ForMember(dest => dest.GameSparePartId, opt => opt.MapFrom(src => src.GameSparePart.GameSparePartId))
                .ForMember(dest => dest.Name, opt => opt.MapFrom(src => src.GameSparePart.Name))
                .ForMember(dest => dest.Type, opt => opt.MapFrom(src => src.GameSparePart.Type))
                .ForMember(dest => dest.Category, opt => opt.MapFrom(src => src.GameSparePart.Category));

            CreateMap<GameMode, GameModeModel>();
            CreateMap<GameModeRule, GameModeRuleModel>();
            CreateMap<GameCoin, GameCoinTypeModel>();
            CreateMap<GameCoinRule, GameCoinRuleModel>();
            CreateMap<GameItem, GameItemModel>();
            CreateMap<GameItemRule, GameItemRuleModel>();
            CreateMap<GameReward, GameRewardModel>();
            CreateMap<GameRewardAttribute, GameRewardAttributeModel>();

            CreateMap<GameSparePart, GameSparePartModel>();
            CreateMap<GameSparePartAttribute, GameSparePartAttributeModel>();

            CreateMap<GameMode, GameModeTypeModel>();
            CreateMap<GameCoin, GameCoinModel>();
            CreateMap<GameCoinRule, SingleGameCoinRuleModel>();
            CreateMap<GameItemRule, SingleGameItemRuleModel>();
            CreateMap<GameModeRule, SingleGameModeRuleModel>();
            CreateMap<GameReward, SingleGameRewardModel>();

            CreateMap<User, GameLeaderboardModel>()
                .ForMember(dest => dest.User, opt => opt.MapFrom(src => new SingleUserModel
                {
                    Username = src.Username,
                    Email = src.Email
                }))
                .ForMember(dest => dest.Experiences, opt => opt.MapFrom(src => src.Attributes.Experiences))
                .ForMember(dest => dest.ElitePoints, opt => opt.MapFrom(src => src.Attributes.ElitePoints))
                .ForMember(dest => dest.Trophies, opt => opt.MapFrom(src => src.Attributes.Trophies));

            CreateMap<GameMatchDetail, GameMatchDetailModel>();

            CreateMap<User, LoginUserModelResponse>();
            CreateMap<User, UserModel>();
            CreateMap<User, SingleUserModel>();
        }
    }
}
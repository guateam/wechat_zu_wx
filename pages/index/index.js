//index.js
//获取应用实例
const app = getApp()
var sliderWidth = 144 // 需要设置slider的宽度，用于计算中间位置
Page({
  data: {
    movies: [{
        url: '../../src/wash-foot01.jpg'
      },
      {
        url: '../../src/wash-foot02.jpg'
      },
      {
        url: '../../src/wash-foot03.jpg'
      },
      {
        url: '../../src/wash-foot04.jpg'
      }
    ],
    current: '1',
    tab1: true,
    tabs: ["项目分类", "优惠活动"],
    activeIndex: 0,
    sliderOffset: 0,
    sliderLeft: 0
  },
  handleChange({
    detail
  }) {
    var index = detail.key
    console.log(index)
    this.setData({
      current: detail.key
    });
    if (index == 1) {
      this.setData({
        tab1: true,
        tab2: false
      })
    } else if (index == 2) {
      this.setData({
        tab1: false,
        tab2: true
      })
    }
  },

  handleChangeScroll({
    detail
  }) {
    this.setData({
      current_scroll: detail.key
    });
  },
  //事件处理函数
  openmap: function() {
    wx.getLocation({
      type: 'gcj02', //返回可以用于wx.openLocation的经纬度
      success(res) {
        const latitude = res.latitude
        const longitude = res.longitude
        wx.openLocation({
          latitude: 30.3036750000,
          longitude: 120.3032260000,
          scale: 18,
          name: '御足堂影院式足道',
          address: '头格月雅城10幢'
        })

      }
    })
  },
  phone: function() {
    wx.makePhoneCall({
      phoneNumber: '13336130250',
    })
  },
  jishiyuyue: function() {
    wx.navigateTo({
      url: '../jishiyuyue/jishiyuyue'
    })
  },
  culture: function() {
    wx.navigateTo({
      url: '../culture/culture',
    })
  },
  recharge: function () {
    wx.navigateTo({
      url: '../recharge/recharge',
    })
  },
  dashangjishi: function () {
    wx.navigateTo({
      url: '../dashangjishi/dashangjishi',
    })
  },
  onLoad: function() {
    var that = this;
    wx.getSystemInfo({
      success: function(res) {
        that.setData({
          sliderLeft: (res.windowWidth / that.data.tabs.length - sliderWidth) / 2,
          sliderOffset: res.windowWidth / that.data.tabs.length * that.data.activeIndex
        });
      }
    });
    if (app.globalData.userInfo) {
      this.setData({
        userInfo: app.globalData.userInfo,
        hasUserInfo: true
      })
    } else if (this.data.canIUse) {
      // 由于 getUserInfo 是网络请求，可能会在 Page.onLoad 之后才返回
      // 所以此处加入 callback 以防止这种情况
      app.userInfoReadyCallback = res => {
        this.setData({
          userInfo: res.userInfo,
          hasUserInfo: true
        })
      }
    } else {
      // 在没有 open-type=getUserInfo 版本的兼容处理
      wx.getUserInfo({
        success: res => {
          app.globalData.userInfo = res.userInfo
          this.setData({
            userInfo: res.userInfo,
            hasUserInfo: true
          })
        }
      })
    }
  },
  tabClick: function(e) {
    this.setData({
      sliderOffset: e.currentTarget.offsetLeft,
      activeIndex: e.currentTarget.id
    });
  },
  swipclick: function(e) {
    //点击图片触发事件
    console.log(this.data.imageUrls[this.data.current]);
  }
  // getUserInfo: function(e) {
  //   console.log(e)
  //   app.globalData.userInfo = e.detail.userInfo
  //   this.setData({
  //     userInfo: e.detail.userInfo,
  //     hasUserInfo: true
  //   })
  // }
})
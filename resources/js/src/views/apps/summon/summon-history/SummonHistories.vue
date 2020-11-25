<!-- =========================================================================================
    File Name: CardActions.vue
    Description: Card with actions
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
    <div class="vx-row">

        <!-- Overview -->
        <div class="vx-col w-full mb-base">
            <vx-card title="Altec Lansing" action-buttons @refresh="closeCardAnimationDemo" style="overflow-y: auto; ">
            <table style="width:100%; min-width: 500px;" class="border-collapse">
                <tr>
                    <th class="p-2 border border-solid d-theme-border-grey-light">Type</th>
                    <th class="p-2 border border-solid d-theme-border-grey-light text-center">Whatsapp</th>
                    <th class="p-2 border border-solid d-theme-border-grey-light text-center">SMS</th>
                    <th class="p-2 border border-solid d-theme-border-grey-light text-center">Voice Call</th>
                    <th class="p-2 border border-solid d-theme-border-grey-light text-center">Email</th>
                </tr>
                <tr>
                    <td class="p-2 border border-solid d-theme-border-grey-light">Email1</td>
                    <td class="border border-solid d-theme-border-grey-light text-center"></td>
                    <td class="border border-solid d-theme-border-grey-light text-center"></td>
                    <td class="border border-solid d-theme-border-grey-light text-center"></td>
                    <td class="p-2 border border-solid d-theme-border-grey-light text-center">Relied: I can join in time</td>
                </tr>
                <tr>
                    <td class="p-2 border border-solid d-theme-border-grey-light">Email2</td>
                    <td class="border border-solid d-theme-border-grey-light text-center"></td>
                    <td class="border border-solid d-theme-border-grey-light text-center"></td>
                    <td class="border border-solid d-theme-border-grey-light text-center"></td>
                    <td class="p-2 border border-solid d-theme-border-grey-light text-center">Unread</td>
                </tr>
                <tr>
                    <td class="p-2 border border-solid d-theme-border-grey-light">Phone1</td>
                    <td class="border border-solid d-theme-border-grey-light text-center">Read</td>
                    <td class="border border-solid d-theme-border-grey-light text-center">Read</td>
                    <td class="border border-solid d-theme-border-grey-light text-center">Replied: I can join in time</td>
                    <td class="p-2 border border-solid d-theme-border-grey-light text-center"></td>
                </tr>
            </table>
            </vx-card>
        </div>    
        <div class="vx-col w-full mb-base" >
            <vx-card title="Margot Henschke" action-buttons @refresh="closeCardAnimationDemo" style=" overflow-y: auto;">
            <table style="width:100%; min-width: 500px;" class="border-collapse">
                <tr>
                    <th class="p-2 border border-solid d-theme-border-grey-light">Type</th>
                    <th class="p-2 border border-solid d-theme-border-grey-light text-center">Whatsapp</th>
                    <th class="p-2 border border-solid d-theme-border-grey-light text-center">SMS</th>
                    <th class="p-2 border border-solid d-theme-border-grey-light text-center">Voice Call</th>
                    <th class="p-2 border border-solid d-theme-border-grey-light text-center">Email</th>
                </tr>
                <tr>
                    <td class="p-2 border border-solid d-theme-border-grey-light">Email1</td>
                    <td class="border border-solid d-theme-border-grey-light text-center"></td>
                    <td class="border border-solid d-theme-border-grey-light text-center"></td>
                    <td class="border border-solid d-theme-border-grey-light text-center"></td>
                    <td class="p-2 border border-solid d-theme-border-grey-light text-center">Relied: I can join in time</td>
                </tr>
                <tr>
                    <td class="p-2 border border-solid d-theme-border-grey-light">Phone1</td>
                    <td class="border border-solid d-theme-border-grey-light text-center">Read</td>
                    <td class="border border-solid d-theme-border-grey-light text-center">Read</td>
                    <td class="border border-solid d-theme-border-grey-light text-center">Replied: I can join in time</td>
                    <td class="p-2 border border-solid d-theme-border-grey-light text-center"></td>
                </tr>
                <tr>
                    <td class="p-2 border border-solid d-theme-border-grey-light">Phone2</td>
                    <td class="border border-solid d-theme-border-grey-light text-center">Read</td>
                    <td class="border border-solid d-theme-border-grey-light text-center">Read</td>
                    <td class="border border-solid d-theme-border-grey-light text-center">Unread</td>
                    <td class="p-2 border border-solid d-theme-border-grey-light text-center"></td>
                </tr>
            </table>
            </vx-card>
        </div>
    </div>
</template>

<script>
export default {
  methods: {
    closeCardAnimationDemo (card) {
      card.removeRefreshAnimation(3000)
    }
  }
}
</script>

package com.example.tabunganku

import android.appwidget.AppWidgetManager
import android.content.Context
import android.content.SharedPreferences
import android.widget.RemoteViews
import es.antonborri.home_widget.HomeWidgetProvider

class BalanceWidgetProvider : HomeWidgetProvider() {
    override fun onUpdate(
        context: Context,
        appWidgetManager: AppWidgetManager,
        appWidgetIds: IntArray,
        widgetData: SharedPreferences
    ) {
        for (appWidgetId in appWidgetIds) {
            val views = RemoteViews(context.packageName, R.layout.balance_widget).apply {
                setTextViewText(R.id.widget_dompet, widgetData.getString("dompet", "Rp 0"))
                setTextViewText(R.id.widget_celengan, widgetData.getString("celengan", "Rp 0"))
                setTextViewText(R.id.widget_gopay, widgetData.getString("gopay", "Rp 0"))
            }
            appWidgetManager.updateAppWidget(appWidgetId, views)
        }
    }
}

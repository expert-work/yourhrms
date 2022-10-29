// To parse this JSON data, do
//
//     final menuModel = menuModelFromJson(jsonString);

import 'dart:convert';

MenuModel menuModelFromJson(String str) => MenuModel.fromJson(json.decode(str));

class MenuModel {
  MenuModel({
    this.result,
    this.message,
    this.data,
  });

  bool? result;
  String? message;
  Data? data;

  factory MenuModel.fromJson(Map<String, dynamic> json) => MenuModel(
    result: json["result"],
    message: json["message"],
    data: Data.fromJson(json["data"]),
  );
}

class Data {
  Data({
    this.data,
  });

  List<Datum>? data;

  factory Data.fromJson(Map<String, dynamic> json) => Data(
    data: List<Datum>.from(json["data"].map((x) => Datum.fromJson(x))),
  );
}

class Datum {
  Datum({
    this.name,
    this.slug,
    this.position,
    this.icon,
  });

  String? name;
  String? slug;
  String? position;
  String? icon;

  factory Datum.fromJson(Map<String, dynamic> json) => Datum(
    name: json["name"],
    slug: json["slug"],
    position: json["position"],
    icon: json["icon"],
  );

  Map<String, dynamic> toJson() => {
    "name": name,
    "slug": slug,
    "position": position,
    "icon": icon,
  };
}

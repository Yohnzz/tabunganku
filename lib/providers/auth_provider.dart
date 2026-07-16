import 'package:flutter/material.dart';
import 'package:supabase_flutter/supabase_flutter.dart';
import '../core/services/auth_service.dart';

class AuthProvider extends ChangeNotifier {
  final AuthService _authService = AuthService();
  bool _isLoading = false;

  bool get isLoading => _isLoading;
  User? get user => _authService.currentUser;

  // Stream untuk memantau status auth secara real-time
  Stream<AuthState> get authStateChanges => _authService.authStateChanges;

  // Login
  Future<String?> login(String email, String password) async {
    _isLoading = true;
    notifyListeners();
    try {
      await _authService.signIn(email: email, password: password);
      _isLoading = false;
      notifyListeners();
      return null;
    } on AuthException catch (e) {
      _isLoading = false;
      notifyListeners();
      return e.message;
    } catch (e) {
      _isLoading = false;
      notifyListeners();
      return "Terjadi kesalahan tidak terduga";
    }
  }

  // Register
  Future<String?> register(String email, String password, String name) async {
    _isLoading = true;
    notifyListeners();
    try {
      await _authService.signUp(email: email, password: password, fullName: name);
      _isLoading = false;
      notifyListeners();
      return null;
    } on AuthException catch (e) {
      _isLoading = false;
      notifyListeners();
      return e.message;
    } catch (e) {
      _isLoading = false;
      notifyListeners();
      return "Gagal mendaftar. Silakan coba lagi.";
    }
  }

  // Logout
  Future<void> logout() async {
    await _authService.signOut();
    notifyListeners();
  }
}
